<?php
$activePage = "wallets";
include("top.php");

$userid = $row["memberID"];

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.cryptocompare.com/api/data/coinlist/",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
 
));

$allcoins = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

//decode the results from the api, so it will be easy to plugin a table. 

$allcoin_results = json_decode($allcoins, true);
 //because of true, it's in an array

        
    


?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-4">
                    <h2>Balances of the Coins</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.php">Dashboard</a>
                        </li>
                        <li class="active">
                            <strong>Your Portfolio</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-sm-8">
                    <div class="title-action">
                        <a href="#" onclick="$('#myModal').modal({'backdrop': 'static'});" class="btn btn-primary">Deposits/Withdraws</a>
                       
                    </div>           
                            <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content animated bounceInRight">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <i class="fa fa-area-chart modal-icon"></i>
                                            <h4 class="modal-title">How much did you invested</h4>
                                            <small class="font-bold">Add here the amount of money you've invested in buying cryptocurrencies </small>
                                        </div>
                                    <form method="post">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="form-group col-md-6"><label>Deposit/Withdraw</label> 
                                                <select name="action" class="form-control">
                                                    <option value="deposit">Deposit</option>
                                                    <option value="withdraw">Withdraw</option>
                                                    
                                                    
                                                </select>
                                                </div>
                                                <div class="form-group col-md-6"><label>Dollar <a href="">(Only option now)</a></label> <input type="input" name="price" placeholder="0.00" class="form-control"></div>
                                            </div>  
                                
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                            <button type="submit" name="add-money"  class="btn btn-primary">Deposit/Withdraw</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                    
                </div>
            </div>

            <div class="wrapper wrapper-content">
                <div class="row">
                    <?php
                    if(strlen($error) > 1){
                        ?>

                    <div class="alert alert-danger alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
                        <?=$error?>
                    </div>
                   <? }
                    if(strlen($success) > 1){?>
                     <div class="alert alert-success alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
                        <?=$success?>
                         </div>
                    <?}?>
                        

                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                
                                <h5>Total Wallets</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">40</h1>
                                <div class="stat-percent font-bold text-success">40% <i class="fa fa-bolt"></i></div>
                                <small>(40/100) Wallets active</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                               
                                <h5>Total Invested</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?=dollar($row["deposits"])
                                    ?> </h1>
                                <div class="stat-percent font-bold text-info">10% <i class="fa fa-level-up"></i></div>
                                <small>Total money invested</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                               
                                <h5>Total All Wallets</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">€ 350,00</h1>
                                <div class="stat-percent font-bold text-navy">42,8% <i class="fa fa-level-up"></i></div>
                                <small>Money back on investment</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                               
                                <h5>Highest Valued Wallet</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">€350,00</h1>
                                <div class="stat-percent font-bold text-danger">100% <i class="fa fa-level-down"></i></div>
                                <small>Ethereum </small>
                            </div>
                        </div>
                    </div>
            </div>
                <div class="row">
                    <div class="ibox float-e-margins">
                         <div class="ibox-title">
                        <h5>Wallets</h5>
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
                                            <th>Date</th>
                                            <th>Coin</th>
                                            <th>Bought with</th>
                                            <th>Amount</th>
                                            <th>Coins Paid</th>
                                            <th>Total Costs</th>
                                            <th>Total Value now</th>
                                            <th>Changed</th>
                                        </tr>
                                        </thead>
                                     <tbody>
                                          <?php

                                         $sqlCoin = "SELECT * FROM portfolio_coins WHERE memberID = ".$userid."";
                                        $stmtCoin = $db->query($sqlCoin);

                                    while($rowCoin  = $stmtCoin->fetch()) {
                                        $coinLink = $rowCoin["coin"];
                                        $coinInfo = infoCoin($coinLink);
                                        
                                        foreach($coinInfo as $coinStat){
                                            
                                            
                                            $sym = $coinStat["symbol"];
                                            
                                            if($sym === ""){
                                                $sym = "IOT";
                                            }
                                            
                                            $tsym = $rowCoin["bought_with"];
                                            
                                            $datetime = $rowCoin["date"];
                                            
                                            $timestamp = strtotime($datetime);
                                         
                                            $historyPrice = historyPrice($sym, $tsym, $timestamp);
                                            
                                            $dateNow =  date('Y-m-d H:i:s');
                                            $timestampNow = strtotime($dateNow - 100);
                                            
                                            $currentPrice = historyPrice($sym, $tsym, $timestampNow);
                                            
                                           
                                            $percentageChanged = getPercentage($currentPrice, $historyPrice);
                                            
                                        $totalWorth = $coinStat["price_usd"] * $rowCoin["amount"];
                                        ?>
                                         <tr>
                                            <td><?=$rowCoin["date"]?></td>
                                            <td><?=$rowCoin["coin"]?></td>
                                            <td><?=$rowCoin["bought_with"]?></td>
                                            <td><?=$rowCoin["amount"]?></td>
                                            <td><?=$rowCoin["price_paid"]?></td>
                                            <td><?=euro($historyPrice)?></td>
                                             <td><?=euro($currentPrice)?></td>
                                            <td><?=euro($totalWorth)?></td>
                                             <td><?=$percentageChanged?></td>

                                         </tr>
                                         <?
                                        
                                        }
                                    }
                                                ?>


                                    </tbody>
                                </table>
                        </div>
                </div>
                </div>
                
            </div>
                
   <?php
include("bottom.php");
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
            $('.chosen-select').chosen({width: "100%"});

});
</script>
