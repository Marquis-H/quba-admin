<template>
  <div>
    <h4 class="font-weight-bold py-3 mb-4">
      {{ $t("TITLE_DASHBOARD") }}
      <div class="text-muted text-tiny mt-1">
        <small class="font-weight-normal">{{ now }}</small>
      </div>
    </h4>

    <!-- Counters -->
    <div class="row">
      <div class="col-sm-6 col-xl-3">
        <b-card class="mb-4">
          <div class="d-flex align-items-center">
            <div class="lnr lnr-shirt display-4 text-info"></div>
            <div class="ml-3">
              <div class="text-muted small">二手闲置</div>
              <div class="text-large">{{ dashboardInfo.statistics.idles }}</div>
            </div>
          </div>
        </b-card>
      </div>
      <div class="col-sm-6 col-xl-3">
        <b-card class="mb-4">
          <div class="d-flex align-items-center">
            <div class="lnr lnr-calendar-full display-4 text-success"></div>
            <div class="ml-3">
              <div class="text-muted small">队伍</div>
              <div class="text-large">{{ dashboardInfo.statistics.teams }}</div>
            </div>
          </div>
        </b-card>
      </div>
      <div class="col-sm-6 col-xl-3">
        <b-card class="mb-4">
          <div class="d-flex align-items-center">
            <div class="lnr lnr-database display-4 text-danger"></div>
            <div class="ml-3">
              <div class="text-muted small">小程序用户数</div>
              <div class="text-large">
                {{ dashboardInfo.statistics.weappUser }}
              </div>
            </div>
          </div>
        </b-card>
      </div>
      <div class="col-sm-6 col-xl-3">
        <b-card class="mb-4">
          <div class="d-flex align-items-center">
            <div class="lnr lnr-users display-4 text-warning"></div>
            <div class="ml-3">
              <div class="text-muted small">管理員</div>
              <div class="text-large">{{ dashboardInfo.statistics.user }}</div>
            </div>
          </div>
        </b-card>
      </div>
    </div>
    <!-- / Counters -->

    <!-- Statistics -->
    <b-card no-body class="mb-4">
      <b-card-header header-tag="h5" class="with-elements border-0 pt-3 pb-0">
        <span class="card-header-title">
          <i class="ion ion-md-stats text-primary"></i>&nbsp; 訪問量
        </span>

        <div class="card-header-elements ml-auto">
          <b-btn-group size="sm">
            <b-btn
              variant="default"
              class="md-btn-flat"
              :class="{ active: displayRange === 7 }"
              @click="displayRange = 7"
              >近7天</b-btn
            >
            <b-btn
              variant="default"
              class="md-btn-flat"
              :class="{ active: displayRange === 15 }"
              @click="displayRange = 15"
              >近15天</b-btn
            >
          </b-btn-group>
        </div>
      </b-card-header>
      <hr class="border-light mb-0" />
      <div class="row no-gutters row-bordered row-border-light" style="vis">
        <div class="d-flex col-md-8 col-lg-12 col-xl-8 align-items-center p-4">
          <dashboard-chart1 :chart-data="line" class="w-100" :height="230" />
        </div>

        <!-- Sources -->
        <div class="col-md-4 col-lg-12 col-xl-4 px-4 pt-4 pb-4">
          <dashboard-chart2 :chart-data="pie" :height="230" />
        </div>
        <!-- / Sources -->
      </div>
    </b-card>
    <!-- / Statistics -->
  </div>
</template>

<script>
import Vue from 'vue'
import VueChartJs from 'vue-chartjs'
import { getDashboardInfo, getDashboardLine } from '@/api/dashboard'

Vue.component('dashboard-chart1', {
  extends: VueChartJs.Line,
  mixins: [VueChartJs.mixins.reactiveProp],
  props: {
    chartdata: {
      type: Object,
      default: function () {
        return { }
      }
    }
  },
  mounted () {
    this.renderChart(this.chartdata, {
      scales: {
        xAxes: [{
          gridLines: {
            display: false
          },
          ticks: {
            fontColor: '#aaa',
            autoSkipPadding: 50
          }
        }],
        yAxes: [{
          gridLines: {
            display: false
          },
          ticks: {
            fontColor: '#aaa',
            maxTicksLimit: 5
          }
        }]
      },

      responsive: false,
      maintainAspectRatio: false
    })
  }
})

Vue.component('dashboard-chart2', {
  extends: VueChartJs.Pie,
  mixins: [VueChartJs.mixins.reactiveProp],
  props: {
    chartdata: {
      type: Object,
      default: function () {
        return { }
      }
    }
  },
  mounted () {
    this.renderChart(this.chartdata, {
      scales: {
        xAxes: [{
          display: false
        }],
        yAxes: [{
          display: false
        }]
      },
      legend: {
        position: 'right',
        labels: {
          boxWidth: 12
        }
      },
      responsive: false,
      maintainAspectRatio: false
    })
  }
})

export default {
  name: 'dashboard',
  metaInfo: {
    title: '首页'
  },
  data () {
    return {
      now: 'Today is Tuesday, 8 February 2018',
      dashboardInfo: {
        statistics: {} // 总数据
      },
      displayRange: 7,
      line: {
        labels: [],
        datasets: []
      },
      pie: {
        labels: [],
        datasets: []
      }
    }
  },
  created () {
    this.getDashboard()
    this.getDashboard2()
  },
  mounted () {
    const charts = this.$children.filter(component => /-chart\d+$/.test(component.$options._componentTag))

    const resizeCharts = () => charts.forEach(chart => chart._data._chart.resize())

    // Initial resize
    resizeCharts()

    // For performance reasons resize charts on delayed resize event
    this.layoutHelpers.on('resize.dashboard', resizeCharts)
  },
  watch: {
    displayRange: function(n, o) {
      this.getDashboard2()
    }
  },
  beforeDestroy () {
    this.layoutHelpers.off('resize.dashboard')
  },
  methods: {
    getDashboard () {
      return new Promise((resolve, reject) => {
        getDashboardInfo().then(res => {
          this.dashboardInfo = res.data
          resolve(true)
        }).catch(err => {
          console.log(err)
          reject(err)
        })
      })
    },
    getDashboard2() {
      var that = this
      return new Promise((resolve, reject) => {
        getDashboardLine({ day: this.displayRange }).then(res => {
          var line = res.data['line']
          var pie = res.data['pie']
          var lineDate = []
          var linepv = []
          var lineuv = []
          var lineTotal = []

          line.forEach(v => {
            if (!v['errcode']) {
              lineDate.push(v['list'][0]['ref_date'])
              linepv.push(v['list'][0]['share_pv'])
              lineuv.push(v['list'][0]['share_uv'])
              lineTotal.push(v['list'][0]['visit_total'])
            }
          })
          that.line = {
            labels: lineDate.reverse(),
            datasets: [{
              label: 'PV',
              data: linepv.reverse(),
              borderWidth: 1,
              backgroundColor: 'rgba(38, 180, 255, 0.1)',
              borderColor: '#26B4FF',
              fill: false
            }, {
              label: 'UV',
              data: lineuv.reverse(),
              borderWidth: 1,
              borderDash: [5, 5],
              backgroundColor: 'rgba(136, 151, 170, 0.1)',
              borderColor: '#8897aa'
            }, {
              label: '访问总数',
              data: lineTotal.reverse(),
              borderWidth: 1,
              borderDash: [5, 5]
            }]
          }
          var pieData = [0, 0, 0]
          pie.forEach(v => {
            if (!v['errcode']) {
              v['list'].forEach(list => {
                switch (list['page_path']) {
                  case 'pages/index/index':
                    pieData[0] += list['page_visit_pv']
                    break
                  case 'pages/idle/index':
                    pieData[1] += list['page_visit_pv']
                    break
                  case 'pages/team/index':
                    pieData[2] += list['page_visit_pv']
                    break
                }
              })
            }
          })
          that.pie = {
            labels: ['主頁', '二手闲置', '比赛'],
            datasets: [{
              data: pieData,
              backgroundColor: ['rgba(99,125,138,0.5)', 'rgba(28,151,244,0.5)', 'rgba(2,188,119,0.5)'],
              borderColor: ['#647c8a', '#2196f3', '#02bc77'],
              borderWidth: 1
            }]
          }
          resolve(true)
        }).catch(err => {
          console.log(err)
          reject(err)
        })
      })
    }
  }
}
</script>
