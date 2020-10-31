<?php


namespace QiniuBundle\Command;

use RuntimeException;
use SplFileInfo;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

/**
 * Class UploadAttachmentsCommand
 * @package QiniuBundle\Command
 */
class UploadAttachmentsCommand extends ContainerAwareCommand
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('qiniu:upload:attachment')
            ->addArgument('bucket', InputArgument::REQUIRED, 'Upload Qiniu bucket name')
            ->setDescription('Upload web/uploads folder files to Qiniu');
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $finder = new Finder();
        $fs = $this->getContainer()->get('filesystem');
        $webPath = realpath($this->getContainer()->get('kernel')->getRootDir() . '/../web');
        $uploadPath = $webPath . '/uploads';
        $client = $this->getContainer()->get('qiniu.client');
        $bucket = $input->getArgument('bucket');

        if (!$fs->exists($uploadPath)) {
            throw new RuntimeException(sprintf('The upload folder is not exist'));
        }

        /** @var SplFileInfo $file */
        foreach ($finder->in($uploadPath) as $file) {
            if ($file->isFile()) {
                $key = str_replace($webPath, '', $file->getRealPath());
                if (strpos($key, '/') === 0) {
                    $key = substr($key, 1);
                }
                try {
                    $client->stat($bucket, $key);
                    $output->writeln(sprintf('<comment>%s exist</comment>', $key));
                    continue;
                } catch (RuntimeException $e) {
                    switch ($e->getCode()) {
                        case 612:
                            $client->uploadFile($bucket, $file->getRealPath(), $key);
                            $output->writeln(sprintf('<info>%s success</info>', $key));
                            break;
                    }
                }
            }
        }
    }
}
