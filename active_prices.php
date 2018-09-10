<?php
$activePage = "active_prices";
include("top.php");

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.coinmarketcap.com/v1/ticker/?limit=0",
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

?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-4">
                    <h2>CoinMarket Exchange</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.php">Home</a>
                        </li>
                        <li class="active">
                            <strong>All cryptocurrencies</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-sm-8">
                    <div class="title-action">
                        <a href="" class="btn btn-primary">This is action area</a>
                    </div>
                </div>
            </div>

            <div class="wrapper wrapper-content">
                <div class="row">
                          <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>All Cryptocurrency displayed underneath eachother </h5>
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

                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                            <tr>   
                                <th></th>
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
                                <td><?=$coin["rank"]?></td>
                                <td><a href="coin_posts.php?name=<?=$coin["id"]?>"><?=$coin["name"];?></a></td>
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
                    
                    
                </div>
            </div>
   <?php
include("bottom.php");
?>
<script>
        $(document).ready(function(){
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });

        });

    </script>
