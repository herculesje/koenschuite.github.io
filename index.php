<?php
$activePage = "dashboard";


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.coinmarketcap.com/v1/ticker/?limit=10",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
 
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

//decode the results from the api, so it will be easy to plugin a table. 

$coin_results = json_decode($response, true);
 //because of true, it's in an array
include("./top.php"); 

//FOLLOWING
$sqlFollowing = "SELECT * FROM following WHERE user_id='$memberID'";
$stmtFollowing = $db->query($sqlFollowing);
$resultFollowing = $stmtFollowing->rowCount();

//FOLLOWERS
$sqlFollowers = "SELECT * FROM following WHERE follower_id='$memberID'";
$stmtFollowers = $db->query($sqlFollowers);
$resultFollowers = $stmtFollowers->rowCount();

//COINSFOLLOWING
$sqlCoinsFollowing = "SELECT * FROM coin_follow WHERE memberID='$memberID'";
$stmtCoinsFollowing = $db->query($sqlCoinsFollowing);
$resultCoinsFollowing = $stmtCoinsFollowing->rowCount();

    ?>

<div class="wrapper wrapper-content">
        <div class="row">
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-success pull-right"></span>
                                <h5>Coins Following</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?=$resultCoinsFollowing?></h1>
                                <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
                                <small>Total coins following</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-info pull-right">Annual</span>
                                <h5>Followers</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?=$resultFollowers?></h1>
                                <div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i></div>
                                <small>New amount invested</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-primary pull-right">All Time</span>
                                <h5>Following</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?=$resultFollowing?></h1>
                                <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div>
                                <small>New amount earned</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-danger pull-right">Low value</span>
                                <h5>Market Value</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?=$sumInvested?></h1>
                                <div class="stat-percent font-bold text-danger">38% <i class="fa fa-level-down"></i></div>
                                <small>New followers this month </small>
                            </div>
                        </div>
                    </div>
        </div>
     <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Top 10 Coins </h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>CoinName</th>
                                <th>Current Price</th>
                                <th>Hour Change</th>
                                <th>24H Change</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            //geef hier alle gerenderde data weer zodat je de actuele koersen kan bekijken.    
                            foreach($coin_results as $coin){
                                ?>
                            <tr>  
                                <td><?=$coin["name"];?></td>
                                <td><?=dollar($coin["price_usd"])?></td>
                                <?
                                    if($coin["percent_change_1h"] > 0){
                                        echo'<td class="text-navy"> <i class="fa fa-level-up"></i> '.$coin["percent_change_1h"].'% </td>';
                                    }elseif($coin["percent_change_1h"] < 0){
                                        echo'<td class="text-warning"> <i class="fa fa-level-down"></i> '.$coin["percent_change_1h"].'% </td>';
                                    }else{
                                        echo'<td class="text-info"> <i class="fa fa-level-up"></i> '.$coin["percent_change_1h"].'% </td>';
                                    }
                                
                                    if($coin["percent_change_24h"] > 0){
                                        echo'<td class="text-navy"> <i class="fa fa-level-up"></i> '.$coin["percent_change_1h"].'% </td>';
                                    }elseif($coin["percent_change_24h"] < 0){
                                        echo'<td class="text-warning"> <i class="fa fa-level-down"></i> '.$coin["percent_change_24h"].'% </td>';
                                    }else{
                                        echo'<td class="text-info"> <i class="fa fa-level-up"></i> '.$coin["percent_change_1h"].'% </td>';
                                    }
                                ?>
                                
                            </tr>
                                <?
                            }
                            ?>
                                
                            
                            </tbody>
                        </table>
                    </div>
                </div>

                        
                </div>

<?php
include("./bottom.php");
?>
    <script>
        $(document).ready(function() {
            $('.chart').easyPieChart({
                barColor: '#f8ac59',
//                scaleColor: false,
                scaleLength: 5,
                lineWidth: 4,
                size: 80
            });

            $('.chart2').easyPieChart({
                barColor: '#1c84c6',
//                scaleColor: false,
                scaleLength: 5,
                lineWidth: 4,
                size: 80
            });

            var data2 = [
                [gd(2012, 1, 1), 7], [gd(2012, 1, 2), 6], [gd(2012, 1, 3), 4], [gd(2012, 1, 4), 8],
                [gd(2012, 1, 5), 9], [gd(2012, 1, 6), 7], [gd(2012, 1, 7), 5], [gd(2012, 1, 8), 4],
                [gd(2012, 1, 9), 7], [gd(2012, 1, 10), 8], [gd(2012, 1, 11), 9], [gd(2012, 1, 12), 6],
                [gd(2012, 1, 13), 4], [gd(2012, 1, 14), 5], [gd(2012, 1, 15), 11], [gd(2012, 1, 16), 8],
                [gd(2012, 1, 17), 8], [gd(2012, 1, 18), 11], [gd(2012, 1, 19), 11], [gd(2012, 1, 20), 6],
                [gd(2012, 1, 21), 6], [gd(2012, 1, 22), 8], [gd(2012, 1, 23), 11], [gd(2012, 1, 24), 13],
                [gd(2012, 1, 25), 7], [gd(2012, 1, 26), 9], [gd(2012, 1, 27), 9], [gd(2012, 1, 28), 8],
                [gd(2012, 1, 29), 5], [gd(2012, 1, 30), 8], [gd(2012, 1, 31), 25]
            ];

            var data3 = [
                [gd(2012, 1, 1), 800], [gd(2012, 1, 2), 500], [gd(2012, 1, 3), 600], [gd(2012, 1, 4), 700],
                [gd(2012, 1, 5), 500], [gd(2012, 1, 6), 456], [gd(2012, 1, 7), 800], [gd(2012, 1, 8), 589],
                [gd(2012, 1, 9), 467], [gd(2012, 1, 10), 876], [gd(2012, 1, 11), 689], [gd(2012, 1, 12), 700],
                [gd(2012, 1, 13), 500], [gd(2012, 1, 14), 600], [gd(2012, 1, 15), 700], [gd(2012, 1, 16), 786],
                [gd(2012, 1, 17), 345], [gd(2012, 1, 18), 888], [gd(2012, 1, 19), 888], [gd(2012, 1, 20), 888],
                [gd(2012, 1, 21), 987], [gd(2012, 1, 22), 444], [gd(2012, 1, 23), 999], [gd(2012, 1, 24), 567],
                [gd(2012, 1, 25), 786], [gd(2012, 1, 26), 666], [gd(2012, 1, 27), 888], [gd(2012, 1, 28), 900],
                [gd(2012, 1, 29), 178], [gd(2012, 1, 30), 555], [gd(2012, 1, 31), 993]
            ];


            var dataset = [
                {
                    label: "Number of orders",
                    data: data3,
                    color: "#1ab394",
                    bars: {
                        show: true,
                        align: "center",
                        barWidth: 24 * 60 * 60 * 600,
                        lineWidth:0
                    }

                }, {
                    label: "Payments",
                    data: data2,
                    yaxis: 2,
                    color: "#1C84C6",
                    lines: {
                        lineWidth:1,
                            show: true,
                            fill: true,
                        fillColor: {
                            colors: [{
                                opacity: 0.2
                            }, {
                                opacity: 0.4
                            }]
                        }
                    },
                    splines: {
                        show: false,
                        tension: 0.6,
                        lineWidth: 1,
                        fill: 0.1
                    },
                }
            ];


            var options = {
                xaxis: {
                    mode: "time",
                    tickSize: [3, "day"],
                    tickLength: 0,
                    axisLabel: "Date",
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: 'Arial',
                    axisLabelPadding: 10,
                    color: "#d5d5d5"
                },
                yaxes: [{
                    position: "left",
                    max: 1070,
                    color: "#d5d5d5",
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: 'Arial',
                    axisLabelPadding: 3
                }, {
                    position: "right",
                    clolor: "#d5d5d5",
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: ' Arial',
                    axisLabelPadding: 67
                }
                ],
                legend: {
                    noColumns: 1,
                    labelBoxBorderColor: "#000000",
                    position: "nw"
                },
                grid: {
                    hoverable: false,
                    borderWidth: 0
                }
            };

            function gd(year, month, day) {
                return new Date(year, month - 1, day).getTime();
            }

            var previousPoint = null, previousLabel = null;

            $.plot($("#flot-dashboard-chart"), dataset, options);

            var mapData = {
                "US": 298,
                "SA": 200,
                "DE": 220,
                "FR": 540,
                "CN": 120,
                "AU": 760,
                "BR": 550,
                "IN": 200,
                "GB": 120,
            };

            $('#world-map').vectorMap({
                map: 'world_mill_en',
                backgroundColor: "transparent",
                regionStyle: {
                    initial: {
                        fill: '#e4e4e4',
                        "fill-opacity": 0.9,
                        stroke: 'none',
                        "stroke-width": 0,
                        "stroke-opacity": 0
                    }
                },

                series: {
                    regions: [{
                        values: mapData,
                        scale: ["#1ab394", "#22d6b1"],
                        normalizeFunction: 'polynomial'
                    }]
                },
            });
        });
    </script>
