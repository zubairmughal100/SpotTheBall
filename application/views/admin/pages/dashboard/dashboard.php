  <?php
    defined('BASEPATH') OR exit("ooops, we are sorry. It's not you, it's us! Please use the back navigation button to go back.");

    ////////////////////////////////////////////////////////////////////////////////////////
    // LOAD ASSETS
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->helper( 'url' );
    $assets = base_url() . "assets/";
    $cssbase = base_url() . "assets/css/";
    $jsbase = base_url() . "assets/js/";

    $base = base_url() . index_page();
    ////////////////////////////////////////////////////////////////////////////////////////

    ////////////////////////////////////////////////////////////////////////////////////////
    // HTML AND HEAD OPEN TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/headers/html/html_head_open_tag');

    ////////////////////////////////////////////////////////////////////////////////////////
    // META TAGS
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/headers/html/meta');

    ////////////////////////////////////////////////////////////////////////////////////////
    // CSS TAGS
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/headers/css/main_style');

    ////////////////////////////////////////////////////////////////////////////////////////
    // CLOSE HEAD TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/headers/html/close_head_tag');

    ////////////////////////////////////////////////////////////////////////////////////////
    // BODY OPEN AND WRAPPER OPEN TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/body/body_open');
    $this->load->view('admin/essentials/body/page_wrapper_open');

    ////////////////////////////////////////////////////////////////////////////////////////
    // SIDEBAR MENU
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/menu/sidebar_menu');

    ////////////////////////////////////////////////////////////////////////////////////////
    // CONTENT WRAPPER OPEN
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/body/content_wrapper_open');

    ////////////////////////////////////////////////////////////////////////////////////////
    // MAIN CONTENT OPEN
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/body/main_content_open');

    ////////////////////////////////////////////////////////////////////////////////////////
    // TOP MENU BAR
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/menu/top_menu');
?>
    
    <!-- Begin Page Content -->
    <div class="container-fluid">

      
      <!-- Row -->
      <div class="row">
          <!-- <div class="col-md-6 d-none">
              <div class="card shadow mb-4">
                <div class="card-header bg-light-blue py-3">
                  <h6 class="m-0 text-black">Todays Top 5 Winners</h6>
                </div>
                <div class="card-body">
                  <div class="stats">
                      <?php if($top_5_game_winner != false){ ?>
                          <table class="table table-borderless">
                            <tbody>
                              <?php foreach ($top_5_game_winner as $key => $gameplay) { ?>
                                  <tr>
                                    <td scope="row" width="50%"><?php echo $gameplay->username; ?></td>
                                    <td><?php if($gameplay->win_lost == 'y'){echo "Won ".$gameplay->total_games." Games";} ?></td>
                                    <td class="text-capitalize"><?php echo $gameplay->game_type; ?> Game</td>
                                    <td width="10%">$<?php echo $gameplay->total_amount; ?></td>
                                  </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                      <?php }else{ ?>
                          <div class="border border-warning rounded p-3">
                              <i class="fas fa-info-circle"></i> No records found
                          </div>
                      <?php } ?>
                  </div>
                </div>
              </div>
          </div>

          <div class="col-md-6 d-none">
              <div class="card shadow mb-4">
                <div class="card-header bg-light-blue py-3">
                  <h6 class="m-0 text-black">Todays Top 5 Losers</h6>
                </div>
                <div class="card-body">
                  <div class="stats">
                      <?php if($top_5_game_loser != false){ ?>
                          <table class="table table-borderless">
                            <tbody>
                              <?php foreach ($top_5_game_loser as $key => $gameplay) { ?>
                                  <tr>
                                    <td scope="row" width="50%"><?php echo $gameplay->username; ?></td>
                                    <td><?php if($gameplay->win_lost == 'n'){echo "Lost ".$gameplay->total_games." Games";} ?></td>
                                    <td class="text-capitalize"><?php echo $gameplay->game_type; ?> Game</td>
                                    <td width="10%">$<?php echo $gameplay->total_amount; ?></td>
                                  </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                      <?php }else{ ?>
                          <div class="border border-warning rounded p-3">
                              <i class="fas fa-info-circle"></i> No records found
                          </div>
                      <?php } ?>
                  </div>
                </div>
              </div>
          </div> -->


          <div class="col-md-6">
              <div class="card shadow mb-4">
                <div class="card-header bg-light-blue py-3">
                  <h6 class="m-0 text-black">Highest Scores</h6>
                </div>
                <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                  <div class="stats">
                      <?php if($higest_score_by_rows != false){ ?>
                          <table class="table table-borderless">
                            <thead>
                              <tr>
                                <th>Username</th>
                                <th>Total Credit Billed</th>
                                <th>Games Played</th>
                                <th>Rows Won</th>
                                <th>Out Of</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($higest_score_by_rows as $key => $gameplay) { ?>
                                  <tr>
                                    <td scope="row"><?php echo $gameplay->username; ?></td>
                                    <td><?php echo $gameplay->total_amount; ?></td>
                                    <td><?php echo $gameplay->total_games; ?></td>
                                    <td><?php echo $gameplay->number_of_rows_won; ?></td>
                                    <td><?php echo $gameplay->number_of_rows_won_out_of; ?></td>
                                  </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                      <?php }else{ ?>
                          <div class="border border-warning rounded p-3">
                              <i class="fas fa-info-circle"></i> No records found
                          </div>
                      <?php } ?>
                  </div>
                </div>
              </div>
          </div>

          <style type="text/css">
            @-webkit-keyframes greenLight {  
                0% { background-color: #02bd02; }
                50% { background-color: #02bd02; }
                75% { background-color: #038f03; }
                100% { background-color: #038f03; }
              }
            .blink {
              margin:5px auto 0px auto; width: 10px; height: 10px; border-radius: 10px; background-color: #02bd02;
              -webkit-animation-name: greenLight;  
              -webkit-animation-iteration-count: infinite;  
              -webkit-animation-duration: 2s; 
            }
          </style>

          <div class="col-md-6">
              <div class="card shadow mb-4">
                <div class="card-header bg-light-blue py-3">
                  <h6 class="m-0 text-black">Active Players (<?php if($online_users != false){echo count($online_users);}else{echo "0";} ?>)</h6>
                </div>
                <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                  <div class="stats">
                      <?php if($online_users != false){ ?>
                          <table class="table table-borderless">
                            <thead>
                              <tr>
                                <th>Username</th>
                                <th>Last Seen day/month/year</th>
                                <th>Browser</th>
                                <th>IP Address</th>
                                <th>Status</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($online_users as $key => $user) { ?>
                                  <tr>
                                    <td scope="row"><?php echo $user->username; ?></td>
                                    <td><?php echo date('d/m/Y H:i:s', strtotime($user->last_seen_datetime)); ?></td>
                                    <td><?php echo $user->user_agent; ?></td>
                                    <td><?php echo $user->ip_address; ?></td>
                                    <td><div class="blink"></div></td>
                                  </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                      <?php }else{ ?>
                          <div class="border border-warning rounded p-3">
                              <i class="fas fa-info-circle"></i> No records found
                          </div>
                      <?php } ?>
                  </div>
                </div>
              </div>
          </div>

          <div class="col-md-6">
              <div class="card shadow mb-4">
                <div class="card-header bg-light-blue py-3">
                  <h6 class="m-0 text-black">Deposits</h6>
                </div>
                <div class="card-body">
                  <div class="stats">
                      <table class="table table-borderless">
                        <tbody>
                            <tr>
                              <td scope="row" width="50%">Today</td>
                              <td class="text-right">$<?php if($todays_total != false){echo $todays_total;}else{echo '0';} ?></td>
                            </tr>

                            <tr>
                              <td scope="row" width="50%">This Month</td>
                              <td class="text-right">$<?php if($monthly_total != false){echo $monthly_total;}else{echo '0';} ?></td>
                            </tr>

                            <tr>
                              <td scope="row" width="50%">This Year</td>
                              <td class="text-right">$<?php if($yearly_total != false){echo $yearly_total;}else{echo '0';} ?></td>
                            </tr>

                            <tr>
                              <td scope="row" width="50%">All Time</td>
                              <td class="text-right">$<?php if($all_time_total != false){echo $all_time_total;}else{echo '0';} ?></td>
                            </tr>
                        </tbody>
                      </table>
                  </div>
                </div>
              </div>
          </div>

          <div class="col-md-6">
              <div class="card shadow mb-4">
                <div class="card-header bg-light-blue py-3">
                  <h6 class="m-0 text-black">Player Signups</h6>
                </div>
                <div class="card-body">
                  <div class="stats">
                      <table class="table table-borderless">
                        <tbody>
                            <tr>
                              <td scope="row" width="50%">Today</td>
                              <td class="text-right"><?php if($total_signup_today != false){echo $total_signup_today;}else{echo '0';} ?></td>
                            </tr>

                            <tr>
                              <td scope="row" width="50%">This Month</td>
                              <td class="text-right"><?php if($total_monthly_signup != false){echo $total_monthly_signup;}else{echo '0';} ?></td>
                            </tr>

                            <tr>
                              <td scope="row" width="50%">This Year</td>
                              <td class="text-right"><?php if($total_yearly_signup != false){echo $total_yearly_signup;}else{echo '0';} ?></td>
                            </tr>

                            <tr>
                              <td scope="row" width="50%">All Time</td>
                              <td class="text-right"><?php if($total_alltime_signup != false){echo $total_alltime_signup;}else{echo '0';} ?></td>
                            </tr>
                        </tbody>
                      </table>
                  </div>
                </div>
              </div>
          </div>
      </div>

      <!-- Content Row -->
      <div class="row">
        <div class="col-xl-12 col-lg-11">
          <!-- Area Chart -->
          <div class="card shadow mb-4">
            <div class="card-header bg-light-blue py-3">
              <h6 class="m-0 text-black">Earning Chart</h6>
            </div>
            <div class="card-body">
              <div class="chart-area">
                <canvas id="yearlyEarnings"></canvas>
              </div>
              <hr>
              Monthly earning overview
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.container-fluid -->

<?php
    ////////////////////////////////////////////////////////////////////////////////////////
    // MAIN CONTENT CLOSE
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/body/main_content_close');

    ////////////////////////////////////////////////////////////////////////////////////////
    // FOOTER
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/footers/html/footer');

    ////////////////////////////////////////////////////////////////////////////////////////
    // CONTENT WRAPPER CLOSE
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/body/content_wrapper_close');

    ////////////////////////////////////////////////////////////////////////////////////////
    // CLOSE PAGE WRAPPER
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/body/page_wrapper_close');

    ////////////////////////////////////////////////////////////////////////////////////////
    // ALL MODALS GHOES UNDER THIS SECTION
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/footers/html/logout_modal');

    ////////////////////////////////////////////////////////////////////////////////////////
    // ALL JS TAGS GOES UNDER THIS SECTION
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/footers/js/footer_common_js');
?>

<script>
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    function number_format(number, decimals, dec_point, thousands_sep) {
      // *     example: number_format(1234.56, 2, ',', ' ');
      // *     return: '1 234,56'
      number = (number + '').replace(',', '').replace(' ', '');
      var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
          var k = Math.pow(10, prec);
          return '' + Math.round(n * k) / k;
        };
      // Fix for IE parseFloat(0.55).toFixed(0) = 0;
      s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
      if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
      }
      if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
      }
      return s.join(dec);
    }

    var jan = '<?php echo $transaction_monthly_report[0]->total; ?>';
    var feb = '<?php echo $transaction_monthly_report[1]->total; ?>';
    var march = '<?php echo $transaction_monthly_report[2]->total; ?>';
    var april = '<?php echo $transaction_monthly_report[3]->total; ?>';
    var may = '<?php echo $transaction_monthly_report[4]->total; ?>';
    var june = '<?php echo $transaction_monthly_report[5]->total; ?>';
    var july = '<?php echo $transaction_monthly_report[6]->total; ?>';
    var august = '<?php echo $transaction_monthly_report[7]->total; ?>';
    var september = '<?php echo $transaction_monthly_report[8]->total; ?>';
    var october = '<?php echo $transaction_monthly_report[9]->total; ?>';
    var november = '<?php echo $transaction_monthly_report[11]->total; ?>';
    var december = '<?php echo $transaction_monthly_report[12]->total; ?>';

    // Area Chart Example
    var ctx = document.getElementById("yearlyEarnings");
    var myLineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Earnings",
          lineTension: 0.3,
          backgroundColor: "rgba(78, 115, 223, 0.05)",
          borderColor: "rgba(78, 115, 223, 1)",
          pointRadius: 3,
          pointBackgroundColor: "rgba(78, 115, 223, 1)",
          pointBorderColor: "rgba(78, 115, 223, 1)",
          pointHoverRadius: 3,
          pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
          pointHoverBorderColor: "rgba(78, 115, 223, 1)",
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: [jan, feb, march, april, may, june, july, august, september, october, november, december],
        }],
      },
      options: {
        maintainAspectRatio: false,
        layout: {
          padding: {
            left: 10,
            right: 25,
            top: 25,
            bottom: 0
          }
        },
        scales: {
          xAxes: [{
            time: {
              unit: 'date'
            },
            gridLines: {
              display: false,
              drawBorder: false
            },
            ticks: {
              maxTicksLimit: 7
            }
          }],
          yAxes: [{
            ticks: {
              maxTicksLimit: 5,
              padding: 10,
              // Include a dollar sign in the ticks
              callback: function(value, index, values) {
                return '$' + number_format(value);
              }
            },
            gridLines: {
              color: "rgb(234, 236, 244)",
              zeroLineColor: "rgb(234, 236, 244)",
              drawBorder: false,
              borderDash: [2],
              zeroLineBorderDash: [2]
            }
          }],
        },
        legend: {
          display: false
        },
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          titleMarginBottom: 10,
          titleFontColor: '#6e707e',
          titleFontSize: 14,
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          intersect: false,
          mode: 'index',
          caretPadding: 10,
          callbacks: {
            label: function(tooltipItem, chart) {
              var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
              return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
            }
          }
        }
      }
    });
</script>

<?php
    ////////////////////////////////////////////////////////////////////////////////////////
    // BODY HTML CLOSE TAG
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->view('admin/essentials/footers/html/body_html_close_tag');
?>