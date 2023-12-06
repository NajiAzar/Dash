@extends('layouts.head')

@section('content')

<div class="content-wrapper">
  <!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-lg-8 mb-4 order-0">
        <div class="card">
          <div class="d-flex align-items-end row">
            <div class="col-sm-7">
              <div class="card-body">
                <h5 class="card-title text-primary">Hi ! 🎉</h5>
                <p class="mb-4">
                  Welcome to <span class="fw-bold">Admin</span> Journey..
                </p>


              </div>
            </div>
            <div class="col-sm-5 text-center text-sm-left">
              <div class="card-body pb-0 px-0 px-md-4">
                <img src="{{ asset('img/illustrations/man-with-laptop-light.png') }}" height="140" alt="View Badge User"
                  data-app-dark-img="illustrations/man-with-laptop-dark.png"
                  data-app-light-img="illustrations/man-with-laptop-light.png" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 order-1">
        <div class="row">
          <div class="col-lg-6 col-md-12 col-6 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <img src="{{ asset('img/icons/unicons/chart-success.png') }}" alt="chart success" class="rounded" />
                  </div>
                  <div class="dropdown">
                    <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true"
                      aria-expanded="false">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                      <a class="dropdown-item" href="{{ route('products.show')}}">View More</a>

                    </div>
                  </div>
                </div>
                <span class="fw-semibold d-block mb-1">Total Products</span>
                <h3 class="card-title mb-2">{{ $totalProducts }}</h3>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-12 col-6 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <img src="{{ asset('img/icons/unicons/wallet-info.png') }}" alt="Credit Card" class="rounded" />
                  </div>
                  <div class="dropdown">
                    <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true"
                      aria-expanded="false">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                      <a class="dropdown-item" href="{{ route('orders.show') }}">View More</a>

                    </div>
                  </div>
                </div>
                <span>Total Orders</span>
                <h3 class="card-title text-nowrap mb-1">{{ $totalOrders }}</h3>
                <small class="text-success fw-semibold">total order value ₹{{ number_format($totalOrderValue, 2)
                  }}</small>

              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Total Revenue -->
      <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
        <div class="card">
          <div class="row row-bordered g-0">
            <div class="col-md-8">
              <h5 class="card-header m-0 me-2 pb-3">Total Revenue</h5>
              <div id="totalRevenueChart" class="px-2"></div>
            </div>
            <div class="col-md-4">
              
            <div id="orderPieChart"></div>
              <!-- <div class="text-center fw-semibold pt-3 mb-2">62% Company Growth</div>

              <div class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">
                <div class="d-flex">
                  <div class="me-2">
                    <span class="badge bg-label-primary p-2"><i class="bx bx-dollar text-primary"></i></span>
                  </div>
                  <div class="d-flex flex-column">
                    <small>2022</small>
                    <h6 class="mb-0">$32.5k</h6>
                  </div>
                </div>
                <div class="d-flex">
                  <div class="me-2">
                    <span class="badge bg-label-info p-2"><i class="bx bx-wallet text-info"></i></span>
                  </div>
                  <div class="d-flex flex-column">
                    <small>2021</small>
                    <h6 class="mb-0">$41.2k</h6>
                  </div>
                </div>
              </div> -->
            </div>
          </div>
        </div>
      </div>
      <!--/ Total Revenue -->
      <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
        <div class="row">
          <div class="col-6 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <img src="{{ asset('img/icons/unicons/paypal.png') }}" alt="Credit Card" class="rounded" />
                  </div>
                  <div class="dropdown">
                    <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown" aria-haspopup="true"
                      aria-expanded="false">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                      <a class="dropdown-item" href="{{ route('cancelledorders.report') }}s">View More</a>

                    </div>
                  </div>
                </div>
                <span class="d-block mb-1">Cancelled Orders</span>
                <h3 class="card-title text-nowrap mb-2">{{ $cancelledOrders }}</h3>
                <small class="text-success fw-semibold">Cancelled order value ₹{{ number_format($cancelledOrdersValue,
                  2) }}</small>

              </div>
            </div>
          </div>
          <div class="col-6 mb-4">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <div class="avatar flex-shrink-0">
                    <img src="{{ asset('img/icons/unicons/cc-primary.png') }}" alt="Credit Card" class="rounded" />
                  </div>
                  <div class="dropdown">
                    <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown" aria-haspopup="true"
                      aria-expanded="false">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="cardOpt1">
                      <a class="dropdown-item" href="{{ route('sales.report') }}">View More</a>
                    </div>
                  </div>
                </div>
                <span class="fw-semibold d-block mb-1">Delivered Orders</span>
                <h3 class="card-title mb-2">{{ $deliveredOrders }}</h3>
                <small class="text-success fw-semibold">Delivered order value ₹{{ number_format($deliveredOrdersValue,
                  2) }}</small>
              </div>
            </div>
          </div>
          <!-- </div>
    <div class="row"> -->

        </div>
      </div>
    </div>
    <div class="row">


      <!-- Transactions -->
      <div class="col-md-12 col-lg-12 order-2 mb-4">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title m-0 me-2">Recent Orders</h5>
            <div class="dropdown">
              <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">

                <a class="dropdown-item" href="{{ route('orders.show') }}">View More</a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <ul class="p-0 m-0">
              @foreach($recentOrders as $order)
              <li class="d-flex mb-4 pb-1">
                <div class="avatar flex-shrink-0 me-3">
                  <img src="{{ asset('img/icons/unicons/paypal.png') }}" alt="User" class="rounded" />
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <small class="text-muted d-block mb-1">{{ $order->shippingAddress->first_name }} {{
                      $order->shippingAddress->last_name }} </small>
                    <h6 class="mb-0">Order ID : #00{{ $order->id }}</h6>
                  </div>
                  <div class="me-2">
                    <small class="text-muted d-block mb-1">Staus </small>
                    <h6 class="mb-0">{{ $order->status }}</h6>
                  </div>
                  <div class="user-progress d-flex align-items-center gap-1">
                    <h6 class="mb-0">{{ $order->total }}</h6>
                    <span class="text-muted">INR</span>
                  </div>
                </div>
              </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
      <!--/ Transactions -->
    </div>
  </div>
  <!-- / Content -->
  <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}" ></script>

  <script>
  const monthlyRevenueData = {!! json_encode($monthlyRevenue) !!};
  const isSomeConditionMet = true; 
  const axisColor = '#888';
  const borderColor = '#ddd'; 
  const cardColor = isSomeConditionMet ? '#ff8c00' : '#00ff00';
  const totalRevenueChartEl = document.querySelector('#totalRevenueChart');
  const monthNames = [
    '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'
  ];
  const currentMonthIndex = new Date().getMonth(); // Get the index of the current month
  const monthName = Array.from({ length: 6 }, (_, i) => {
    const monthIndex = (currentMonthIndex - i + 12) % 12; // Ensure it wraps around to the previous year
    return [
      'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
    ][monthIndex];
  }).reverse(); // Reverse the array to have the months in chronological order

  console.log(monthName);

  // Filter only the last 6 months' data
  const last6MonthsData = {};
  const currentMonth = new Date().getMonth() + 1; // Adding 1 because months are 0-indexed
  for (let i = 0; i < 6; i++) {
    const monthIndex = (currentMonth - i + 12) % 12; // Ensure it wraps around to the previous year
    const monthKey = monthNames[monthIndex];
    last6MonthsData[monthKey] = monthlyRevenueData[monthKey] || 0;
  }

  console.log(last6MonthsData);

  if (typeof totalRevenueChartEl !== 'undefined' && totalRevenueChartEl !== null) {
    const totalRevenueChartOptions = {
      series: [
        {
          name: 'Monthly Revenue',
          data: monthNames.map(month => last6MonthsData[month] || 0)
        }
      ],
      chart: {
        height: 300,
        stacked: true,
        type: 'bar',
        toolbar: { show: false }
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '20%',
          borderRadius: 12,
          startingShape: 'rounded',
          endingShape: 'rounded'
        }
      },
      colors: [config.colors.primary, config.colors.info],
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'smooth',
        width: 6,
        lineCap: 'round',
        colors: [cardColor]
      },
      legend: {
        show: true,
        horizontalAlign: 'left',
        position: 'top',
        markers: {
          height: 8,
          width: 8,
          radius: 12,
          offsetX: -3
        },
        labels: {
          colors: axisColor
        },
        itemMargin: {
          horizontal: 10
        }
      },
      grid: {
        borderColor: borderColor,
        padding: {
          top: 0,
          bottom: -8,
          left: 20,
          right: 20
        }
      },
      xaxis: {
        categories: monthName, 
        labels: {
          style: {
            fontSize: '13px',
            colors: axisColor
          }
        },
        axisTicks: {
          show: false
        },
        axisBorder: {
          show: false
        }
      },
      yaxis: {
        labels: {
          style: {
            fontSize: '13px',
            colors: axisColor
          }
        }
      },
      responsive: [
        {
          breakpoint: 1700,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '32%'
              }
            }
          }
        },
        {
          breakpoint: 1580,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '35%'
              }
            }
          }
        },
        {
          breakpoint: 1440,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '42%'
              }
            }
          }
        },
        {
          breakpoint: 1300,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '48%'
              }
            }
          }
        },
        {
          breakpoint: 1200,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '40%'
              }
            }
          }
        },
        {
          breakpoint: 1040,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 11,
                columnWidth: '48%'
              }
            }
          }
        },
        {
          breakpoint: 991,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '30%'
              }
            }
          }
        },
        {
          breakpoint: 840,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '35%'
              }
            }
          }
        },
        {
          breakpoint: 768,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '28%'
              }
            }
          }
        },
        {
          breakpoint: 640,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '32%'
              }
            }
          }
        },
        {
          breakpoint: 576,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '37%'
              }
            }
          }
        },
        {
          breakpoint: 480,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '45%'
              }
            }
          }
        },
        {
          breakpoint: 420,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '52%'
              }
            }
          }
        },
        {
          breakpoint: 380,
          options: {
            plotOptions: {
              bar: {
                borderRadius: 10,
                columnWidth: '60%'
              }
            }
          }
        }
      ],
      states: {
        hover: {
          filter: {
            type: 'none'
          }
        },
        active: {
          filter: {
            type: 'none'
          }
        }
      }
    };

    const totalRevenueChart = new ApexCharts(totalRevenueChartEl, totalRevenueChartOptions);
    totalRevenueChart.render();
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


<script>
  // Assuming you have the orderData variable available in your Blade view
  const orderData = {!! json_encode([
    'totalOrders' => $totalOrders,
    'deliveredOrders' => $deliveredOrders,
    'cancelledOrders' => $cancelledOrders,
  ]) !!};
console.log(orderData);
  const orderPieChartOptions = {
    chart: {
      type: 'pie', // Specify the chart type as 'pie'
      height: 300,
      toolbar: { show: false }
    },
    series: [orderData.totalOrders, orderData.deliveredOrders, orderData.cancelledOrders],
    labels: ['Total Orders', 'Delivered Orders', 'Cancelled Orders'],
    colors: ['#4CAF50', '#2196F3', '#F44336'], // Custom colors for each section
    legend: {
      show: true,
      position: 'bottom',
      horizontalAlign: 'center',
      fontSize: '14px'
    }
  };

  // Now, use orderPieChartOptions to create your pie chart
  const orderPieChart = new ApexCharts(document.querySelector("#orderPieChart"), orderPieChartOptions);
  orderPieChart.render();
</script>

  @endsection