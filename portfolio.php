<?php
$activePage = "portfolio";
include("top.php");

$userid = $row["memberID"];

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.coinmarketcap.com/v1/ticker/",
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

$error = "";
$success = "";

if(isset($_POST['addInvestment'])){
        $coin_name = $_POST["coin_name"];
        $coin_bought_with = $_POST["coin_bought_with"];
        $amount_bought = $_POST["amount_bought"];
        $priceBoughtFor = $_POST["price_paid"];
        $current_date = date('Y-m-d H:i:s');
        $date = $_POST["date_bought"];
        $status_coin = 1;

        if(strlen($coin_name) > 2){
            if(strlen(coin_bought_with) > 2){
                if($amount_bought > 0){
                    if($priceBoughtFor > 0){
                  $stmt = $db->prepare('INSERT INTO portfolio_coins (memberID,coin, bought_with, amount, price_paid, date, status) VALUES (:userid, :coin, :boughtWith, :amount_bought, :price_paid, :date, :status)');
                $stmt->execute(array(
                    ':userid' => $userid,
                    ':coin' => $coin_name,
                    ':boughtWith' => $coin_bought_with, 
                    ':price_paid' => $priceBoughtFor, 
                    ':amount_bought' => $amount_bought, 
                    ':date' => $date,
                    ':status' => $status_coin
               ));

                        //CHECK HERE IF THERE ALREADY EXISTS A WALLET IF NOT CREATE ONE
                    }else
                        //$error = "Make sure you enter a correct price you bought the coins for!";
                        $error = $date;


                }else
                    $error = "Make sure you enter a correct amount of coins you bought.";


            }


        }
    }



?>
<style>
    #line-chart{
        height: 150px;
    }
</style>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-4">
                    <h2>Your own GoldMine</h2>
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
                        <a href="#" onclick="$('#myModal').modal({'backdrop': 'static'});" class="btn btn-primary">Add Investment</a>
                       
                    </div>           
                            <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content animated bounceInRight">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <i class="fa fa-area-chart modal-icon"></i>
                                            <h4 class="modal-title">Add here your coin</h4>
                                            <small class="font-bold">Here you can add coins to your portfollio so you will have nice overview .</small>
                                        </div>
                                    <form method="post" name="port">
                                        <div class="modal-body">
                                            <div class="row">
                                            <div class="form-group col-md-6"><label>Coin Bought</label>
                                                <select data-placeholder="Choose here the coin you bought..." class="chosen-select" name="coin_name"  tabindex="2">
                                                <?php
                                                    //geef hier alle gerenderde data weer zodat je de actuele koersen kan bekijken.    
                                                    foreach($allcoin_results as $coin){
                                                        ?>
                                                    <option value="<?=$coin["id"]?>">  
                                                        <?=$coin["name"];?> (<?=$coin["symbol"];?>)
                                                    </option>
                                                        <?
                                                    }
                                                    ?>
                                                    </select>
                                            </div>
                                            <div class="form-group col-md-6 pull-right"><label>Bought With</label>   <select data-placeholder="Choose here the coin you bought..." class="chosen-select" name="coin_bought_with"  tabindex="2">
                                                    <option value="bitcoin">BitCoin (BTC)</option>
                                                    <option value="ethereum">Ethereum (ETH)</option>
                                                    <option value="EUR">Euro (EUR)</option>
                                                    <option value="USD">US Dollar (USD)</option>
                                                    
                                                    </select></div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6"><label id="calc-option">Price per Coin</label> <input type="input" id="price_per_coin" name="price_paid" placeholder="0.0000" class="form-control" onchange="perCoin()"></div>
                                                
                                                <div class="form-group col-md-6 pull-right"><label>Total Coins</label> <input type="input" id="total_paid" name="amount_bought" placeholder="100.000" class="form-control"></div>
                                            </div>
                                             <div class="row">
                                                   <div class="form-group col-md-6"><label id="calc-option">Amount Bought</label> <input type="input" id="amountbought" name="amount_bought" placeholder="0.0000" class="form-control" onchange="amountBought()"></div>
                                                
                                                <div class="form-group col-md-6 pull-right"><label>Date Bought</label> <input type="date" id="date_bought" name="date_bought" placeholder="100.000" class="form-control"></div>

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
                <?}?>
                    </div>
                </div>
                <div class="row">
                   
                            
                            <?php
                           
                             $sqlCoin = "SELECT * FROM portfolio_coins WHERE memberID = ".$userid."";
                            $stmtCoin = $db->query($sqlCoin);


                        $sum_total_portfolio = 0;
                        
                    //!!! NOT WORKING YET !!! MAKE SURE THAT YOU CHECK IF THE PERSON HAS ANY COINS IN HIS PORTF!!!
                    if(1 == 1){
                        while($rowCoin  = $stmtCoin->fetch()) {

                                    $coin_initial = $rowCoin["coin"];
                                    $coin_bought_with = $rowCoin["bought_with"];
                                    $curl = curl_init();
                            
                                    

                                    curl_setopt_array($curl, array(
                                      CURLOPT_URL => "https://api.coinmarketcap.com/v1/ticker/".$coin_initial."/",
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
                                foreach($coin_results as $coinStat){
                                 
                                    
                                    
                              
                                $total_portfolio_value = $coinStat["price_usd"] * $rowCoin["amount"];
                                    
                                    //get the price paid for at that time. 
                                    $sym = $coinStat["symbol"];
                                    $tsym = $rowCoin["bought_with"];
                                    
                                    $datetime_bought = $rowCoin["date"];
                                    $timestamp = strtotime($datetime_bought);
                                    
                                    
                                    $historyPrice = historyPrice($tsym, "EUR", $timestamp);
                                    
                                    $totalPaid = $historyPrice * $rowCoin["price_paid"];
                            ?>
                    <div class="col-lg-4">
                        <div class="portfolio-box">
                            <div class="row">
                                <div class="col-md-12">
                                     <span class="pull-right"><?=$rowCoin["exchange"]?></span>
                                    <span class="pull-left"><?=$rowCoin["bought_with"]?></span>
                                    <h3 class="text-center"><img src="https://files.coinmarketcap.com/static/img/coins/32x32/<?=$coinStat["id"]?>.png" alt="Icon Coin"> <?=$coinStat["name"]?></h3>
                                </div>
                               
                            </div>
                            <div class="row">
                            
                            </div>
                                <h1 class="no-margins text-center"><?=euro($total_portfolio_value)?></h1>
                                <div class="stat-percent font-bold text-success"><?=$rowCoin["amount"]?> <i class="fa fa-bolt"></i></div>
                                <small>Total costs: <?=$historyPrice*$rowCoin["price_paid"]?></small>
                        </div>
                             
                    </div>
                            <?
                        
                                }
                        }
                                    
                                    
                                }else{
                                    echo"You don't have any coins in your portfolio";
                                }
                                ?>
                        
                        
                
                </div>
                <!-- Building a modal --> 
                <div class="modal inmodal" id="coinDetails" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content animated flipInX">
                                        <div class="modal-header">
                                            
                                            <h1><img src="https://files.coinmarketcap.com/static/img/coins/32x32/vechain.png" class="img-circle  m-b-md" alt="profile">VeChain</h1>
                                          
                                        </div>
                                        <div class="modal-body">
                                            <div class="modal-coin-details"> 
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h3>26,24518 VEC</h3>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h3>$ 147.74</h3>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-1">
                                                        <!--<div id="sparkline1"></div> -->
                                                        <img src="img/line-chart-not-available.png" />
                                                    </div>         
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h3 class="text-navy"><i class="fa fa-level-up"></i> 20,15%</h3>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h3>$ 147.74</h3>
                                                    </div>
                                                </div>
                                                <div class="row text-center">
                                                    You have bought VEN on Binance for 0.00239 ETH (12 Oct 2018)
                                                </div>
                                            </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
            </div>
                
   <?php
include("bottom.php");
?>
         
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
  <!-- Sparkline -->
    <script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>               
              

          
<script>
    $(document).ready(function() {
       var sparklineCharts = function(){
                 $("#sparkline1").sparkline([34, 43, 43, 35, 44, 32, 44, 52], {
                     type: 'line',
                     width: '100%',
                     height: '160',
                     lineColor: '#1ab394'
                 });
        };
        var sparkResize;

        var sparkResize;

            $(window).resize(function(e) {
                clearTimeout(sparkResize);
                sparkResize = setTimeout(sparklineCharts, 500);
            });

        sparklineCharts();
      

        
       


      $('.chosen-select').chosen({width: "250px"});
});
    
   


    
</script>
