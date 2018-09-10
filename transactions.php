<?php
include("top.php");


$coin_name = $_GET['name'];

$coin_details = infoCoin($coin_name);

foreach($coin_details as $coinStat){

if($coinStat["id"] == $coin_name ){
 
?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-4">
                    <h2><?=$coin_name?> Transactions</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.html">Dashboard</a>
                        </li>
                        <li class="active">
                            <strong>Transaction</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-sm-8">
                     <div class="title-action">
                        <a href="#" onclick="$('#myModal').modal({'backdrop': 'static'});" class="btn btn-primary">Add Investment</a>
                       
                    </div>           
                            <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content animated bounceInRight">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <i class="fa fa-area-chart modal-icon"></i>
                                            <h4 class="modal-title">Cell <?=$coin_name?></h4>
                                            <small class="font-bold">Coins can only be sold when you already bought them.</small>
                                        </div>
                                    <form method="post" name="port">
                                        <div class="modal-body">
                                            <div class="row">
                                            <div class="form-group col-md-4"><label>Sold With</label>   <select data-placeholder="Choose here the coin you bought..." class="chosen-select" name="coin_bought_with"  tabindex="2">
                                                    <option value="bitcoin">BitCoin (BTC)</option>
                                                    <option value="ethereum">Ethereum (ETH)</option>
                                                    <option value="EUR">Euro (EUR)</option>
                                                    <option value="USD">US Dollar (USD)</option>
                                                    
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-8 pull-right"><label>Date Bought</label> <input type="date" id="date_bought" name="date_bought" placeholder="" class="form-control"></div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12"><label id="calc-option">Price per Coin</label> <input type="input" id="price_per_coin" name="price_paid" placeholder="0.0000" class="form-control" onchange="perCoin()"></div>
                                                
                                            </div>
                                             <div class="row">
                                                   <div class="form-group col-md-12"><label id="calc-option">Amount Bought</label> <input type="input" id="amountbought" name="amount_bought" placeholder="0.0000" class="form-control" onchange="amountBought()"></div>
                                                
                                            </div>
                                             <div class="row">
                                                   <div class="form-group col-md-12"><label id="calc-option">Sold Totally For</label> <input type="input" id="sold_total" name="sold_total" placeholder="0.0000" class="form-control" onchange="totalSold()"></div>
                                                
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                            <button type="submit" name="addInvestment"  class="btn btn-primary">Add Investment</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>

            <div class="wrapper wrapper-content">
                <div class="row animated fadeInRight">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                   <!-- <div class="text-center float-e-margins p-md">
                    <a href="#" class="btn btn-xs btn-primary" id="lightVersion">Volledig overzicht</a>
                    <a href="#" class="btn btn-xs btn-primary" id="darkVersion">Aankoop geschiedenis</a>
                    <a href="#" class="btn btn-xs btn-primary" id="leftVersion">Verkoop geschiedenis</a>
                    </div>-->
                    <div  id="ibox-content">

                        <div id="vertical-timeline" class="vertical-container light-timeline center-orientation">
                            <?
                            $userid = $row["memberID"];
                            $coin_id = $coinStat["id"];
                            
                            
                            $sqlCoin = "SELECT * FROM portfolio_coins WHERE memberID = :userid AND coin = :coin";
                            $stmtCoin = $db->prepare($sqlCoin);
                            $stmtCoin->execute(array(
                                ':userid' => $userid,
                                ':coin' => $coin_id

                           ));


      
                            while($rowCoin  = $stmtCoin->fetch()) {
                                
                                $boughtWith = $rowCoin["bought_with"];
                                $coinInitial = $coinStat["symbol"];
                                //get current price from cryptocompare 
                                $currentValue = currentPrice($coinInitial,$boughtWith);
                                
                                //get euro value of pricepaid. 
                                $totalValue = $currentValue * $rowCoin["amount"];
                                
                                //  HISTORY VALUE
                                $datetime_bought = $rowCoin["date"];
                                $timestamp = strtotime($datetime_bought);
                                $historyValue = historyPrice($boughtWith, "USD", $timestamp);
                                
                                $dollarValueNow = currentPrice($boughtWith, "USD");
                                $boughtWithValuedTotal = $dollarValueNow * $amount_bought ;
                               
                                
                                $historyTotalValue = $historyValue*$rowCoin["price_paid"] * $amount_bought;
                                
                                
                              ?>
                            <?
                                        if($rowCoin["status"] == 1){
                                        
                                        ?>
                                        
                            <div class="vertical-timeline-block">
                                <div class="vertical-timeline-icon navy-bg">
                                    <i class="fa fa-plus"></i>
                                </div>

                                <div class="vertical-timeline-content transaction-content">
                                    <div class="row">
                                        
                                        <div class="col-md-4 left">
                                             <img src="img/SVG/ETH.svg" height="65px"><br>
                                           <?=$totalValue?>
                                            <br>
                                            <span>(<?=$rowCoin["amount"]?> <?=$coinInitial?>)</span>
                                                
                                        </div>
                                        <div class="col-md-8">
                                            <center>Bought on: <?=$rowCoin["date"]?></center>
                                            
                                            <table width="100%" class="table">
                                                <tr>
                                                    <td><span class="profit-box">250%</span></td>
                                                    <td><span class="profit-box loss-box">$12,03</span></td>
                                                </tr>
                                                <tr>
                                                    <td><?=$currentValue?> <?=$boughtWith?></td>
                                                    <td><b>$<?=$totalValue?> <?=$boughtWith?></b></td>
                                                </tr>
                                                <tr>
                                                    <td><?=$rowCoin["price_paid"]?> <?=$boughtWith?></td>
                                                    <td><b><?=$historyValue*$rowCoin["price_paid"]?> USD</b></td>
                                                </tr>
                                            </table>
                                        </div>
                                        </div>
                                    <span class="vertical-date">
                                        Today <br/>
                                        <small>Dec 24</small>
                                    </span>
                                </div>
                            </div>
                                        <?}else{
                                        ?> 
                                 <div class="vertical-timeline-block">
                                <div class="vertical-timeline-icon red-bg">
                                    <i class="fa fa-minus"></i>
                                </div>

                                <div class="vertical-timeline-content transaction-content">
                                    <div class="row">
                                        <div class="col-md-4 left">
                                             <img src="img/SVG/ETH.svg" height="65px"><br>
                                            $291,10<br>
                                            <span>(1,001 ETH)</span>
                                                
                                        </div>
                                         <div class="col-md-4 left">
                                             <span class="profit-box">320,04$</span>
                                             <br>
                                             <i class="fa fa-exchange fa-3x text-color" aria-hidden="true"></i>
                                             <br>
                                            <span class="profit-box loss-box">320,04%</span> 
                                        </div>
                                         <div class="col-md-4 left">
                                             <img src="img/SVG/ETH.svg" height="65px"><br>
                                            $291,10<br>
                                            <span>(1,001 ETH)</span>
                                                
                                        </div>
                                        
                                    </div>
                                    
                                    <span class="vertical-date">
                                        SOLD <br/>
                                        <small>New balance: $1002,02</small>
                                    </span>
                                </div>
                            </div>
                                            <?
                                        }?>
                                    
                            <?
                            }
    
                            ?>
                            
                            
                            <div class="vertical-timeline-block">
                                <div class="vertical-timeline-icon navy-bg">
                                    <i class="fa fa-plus"></i>
                                </div>

                                <div class="vertical-timeline-content transaction-content">
                                    <div class="row">
                                        <div class="col-md-4 left">
                                             <img src="img/SVG/ETH.svg" height="65px"><br>
                                            $291,10
                                            <br>
                                            <span>(1,001 ETH)</span>
                                                
                                        </div>
                                        <div class="col-md-8">
                                            <center>Bought on: 23-12-2017 15:20:10</center>
                                            
                                            <table width="100%" class="table">
                                                <tr>
                                                    <td><span class="profit-box">250%</span></td>
                                                    <td><span class="profit-box loss-box">$12,03</span></td>
                                                </tr>
                                                <tr>
                                                    <td>0,0010 ETH</td>
                                                    <td><b>$10,03</b></td>
                                                </tr>
                                                <tr>
                                                    <td>0,0011 ETH</td>
                                                    <td><b>$12,03</b></td>
                                                </tr>
                                            </table>
                                        </div>
                                    
                                    </div>
                                    <span class="vertical-date">
                                        Today <br/>
                                        <small>Dec 24</small>
                                    </span>
                                </div>
                            </div>

                            <div class="vertical-timeline-block">
                                <div class="vertical-timeline-icon red-bg">
                                    <i class="fa fa-minus"></i>
                                </div>

                                <div class="vertical-timeline-content transaction-content">
                                    <div class="row">
                                        <div class="col-md-4 left">
                                             <img src="img/SVG/ETH.svg" height="65px"><br>
                                            $291,10<br>
                                            <span>(1,001 ETH)</span>
                                                
                                        </div>
                                         <div class="col-md-4 left">
                                             <span class="profit-box">320,04$</span>
                                             <br>
                                             <i class="fa fa-exchange fa-3x text-color" aria-hidden="true"></i>
                                             <br>
                                            <span class="profit-box loss-box">320,04%</span> 
                                        </div>
                                         <div class="col-md-4 left">
                                             <img src="img/SVG/ETH.svg" height="65px"><br>
                                            $291,10<br>
                                            <span>(1,001 ETH)</span>
                                                
                                        </div>
                                        
                                    </div>
                                    
                                    <span class="vertical-date">
                                        SOLD <br/>
                                        <small>New balance: $1002,02</small>
                                    </span>
                                </div>
                            </div>

                            <div class="vertical-timeline-block">
                                <div class="vertical-timeline-icon lazur-bg">
                                    <i class="fa fa-coffee"></i>
                                </div>

                                <div class="vertical-timeline-content">
                                    <h2>Coffee Break</h2>
                                    <p>Go to shop and find some products. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's. </p>
                                    <a href="#" class="btn btn-sm btn-info">Read more</a>
                                    <span class="vertical-date"> Yesterday <br/><small>Dec 23</small></span>
                                </div>
                            </div>

                            <div class="vertical-timeline-block">
                                <div class="vertical-timeline-icon yellow-bg">
                                    <i class="fa fa-phone"></i>
                                </div>

                                <div class="vertical-timeline-content">
                                    <h2>Phone with Jeronimo</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, optio, dolorum provident rerum aut hic quasi placeat iure tempora laudantium ipsa ad debitis unde? Iste voluptatibus minus veritatis qui ut.</p>
                                    <span class="vertical-date">Yesterday <br/><small>Dec 23</small></span>
                                </div>
                            </div>

                            <div class="vertical-timeline-block">
                                <div class="vertical-timeline-icon lazur-bg">
                                    <i class="fa fa-user-md"></i>
                                </div>

                                <div class="vertical-timeline-content">
                                    <h2>Go to the doctor dr Smith</h2>
                                    <p>Find some issue and go to doctor. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s. </p>
                                    <span class="vertical-date">Yesterday <br/><small>Dec 23</small></span>
                                </div>
                            </div>

                            <div class="vertical-timeline-block">
                                <div class="vertical-timeline-icon navy-bg">
                                    <i class="fa fa-comments"></i>
                                </div>

                                <div class="vertical-timeline-content">
                                    <h2>Chat with Monica and Sandra</h2>
                                    <p>Web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like). </p>
                                    <span class="vertical-date">Yesterday <br/><small>Dec 23</small></span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            </div>
                
                
                
            </div>
   <?php
                                  }}
include("bottom.php");
?>
