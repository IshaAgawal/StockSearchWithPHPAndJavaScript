
<html>
<head>
    
<style>

li {
    align-content: center;
}
    
.textBody {
    background-color: #F1F3F4;
    border: 1px solid #E3E7EA;
    margin: 0px auto;
    height: 20%;
    width: 30%;       
    text-align: center;
}

table.table1 {
    border: 0px  #F1F3F4;
    text-decoration: none; 
}

table.table1 td, th {
   border: 0px  #F1F3F4;
    text-decoration: none; 
}
    
hr {
    width : 90%;
    border-color: #E3E7EA;
    margin-top: 0.05px;
    align-self: center;
}

.stockTable {
    margin: 0 auto;
    align-items: center;
    width: 1200px;
    text-decoration: none; 
}

.stockTable.container{
    align-self: center;
    align-content: center;
    align-items: center;
    text-decoration: none; 
}

table.table2 {
    width: 900px;
    border-collapse:collapse;
    border: 1px solid #E3E7EA;
    border-color:#E3E7EA;
    margin:0 auto;
     text-decoration: none; 
}

table.table2 td, th {
    border: 1px solid #E3E7EA;
     text-decoration: none; 
    
}
    
    table.table3 {
    width: 900px;
    border-collapse:collapse;
    border: 1px solid #E3E7EA;
    border-color:#E3E7EA;
    margin:0 auto;
    height : 25%;
    text-decoration: none; 
    font-family: sans-serif;
    font-size: 11px;
}
    
    table.table3 td, th {
    border: 1px solid #E3E7EA;
    vertical-align: middle;
    text-decoration: none; 
    font-family: sans-serif;
    font-size: 11px;
}

    .newsTitle {
        
        color: blue;
        margin-right: 25px;
        text-decoration: none; 
        font-size: 11px;
    }
    
a {
        text-decoration: none;
}
</style>

<script src="https://code.highcharts.com/highcharts.src.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>

    
<script type="text/javascript">
    
//var jsonObj;
    
    
function showNews(newJson) {
        
        
if (document.getElementById("newsImage").src == "http://cs-server.usc.edu:45678/hw/hw6/images/Gray_Arrow_Down.png") 
        {
            document.getElementById("newsImage").src = "http://cs-server.usc.edu:45678/hw/hw6/images/Gray_Arrow_Up.png";
         
               document.getElementById("newsText").innerHTML = "click to hide stock news";
        }
        else 
        {
            document.getElementById("newsImage").src = "http://cs-server.usc.edu:45678/hw/hw6/images/Gray_Arrow_Down.png";
             document.getElementById("newsText").innerHTML = "click to show stock news";
        }
        
          var myTableDiv = document.getElementById("container2");
          if(myTableDiv.childNodes.length == 0)
            {
                createNewsTable(newJson);
                myTableDiv.style.display="block";
                return;
                
            }
          var currentDisplay = myTableDiv.style.display;
          if(currentDisplay === "block")
              {
                  myTableDiv.style.display="none";
              }
        else{
             myTableDiv.style.display="block";
        }
        
    }
    
    
function createNewsTable(newsJson) {
        
    var myTableDiv = document.getElementById("container2");
        
    var tbl = document.createElement('table');
        
    tbl.setAttribute('class' , 'table3');
        
    var tbdy = document.createElement('tbody');
    tbl.appendChild(tbdy);
        
    for (var i = 0; i < 5 && i < newsJson.length ; i++) {
        var tr = document.createElement('tr');
        tbdy.appendChild(tr);
        
    var items = Object.values(newsJson[i]);
        
       
    var td = document.createElement('td');
    var link = document.createElement('a');
    var text = document.createTextNode(items[0] + " ");
    
    link.appendChild(text);
    link.setAttribute('href', items[1]);
    link.setAttribute('target', "_blank");
    link.setAttribute('class','newsTitle');
       
    td.appendChild(link);//.appendChild(link);
        
      
  
    var pubDate = ("Publicated Time:").concat(items[2]);

   
    td.appendChild(document.createTextNode(pubDate));
    tr.appendChild(td);
 }
        
  myTableDiv.appendChild(tbl); 
}
    
    
    
  
    
function createChartWithJSONForStoch(jsonObj) {
        
    var processed_json_slowK = new Array();
    var processed_json_slowD = new Array();    
    var symbol = jsonObj["Meta Data"]["1: Symbol"];   // MSFT, etc.
    var indicator = jsonObj["Meta Data"]["2: Indicator"]; 
    
    var indicatorSplitBySpace = indicator.split(" ");
    var symbolKey = indicatorSplitBySpace[indicatorSplitBySpace.length-1];
    
    var yaxisData = symbolKey.slice(1,-1);
    
    
    var indicatorData =Object.values(jsonObj)[1];
    var data = Object.values(Object.values(indicatorData));
    var dates = Object.keys(indicatorData);
    var processed_dates = new Array();
    var k = 0;

   for (i = 0; i < dates.length && k < 126; i++) {       
      var datestring = dates[i];
      var mm = datestring.substring(5,7);
      var dd = datestring.substring(8,10);
      var dateInMMDD = (mm.concat("/")).concat(dd);
      processed_dates.push(dateInMMDD);
       k++;
  }
    
    k = 0;

    for (i = 0; i < data.length && k < 126; i++) {
        var j = Object.values(data[i])[0];
        processed_json_slowK.push(parseFloat((j).substring(0,5))); 
        j = Object.values(data[i])[1];
        processed_json_slowD.push(parseFloat((j).substring(0,5))); 
        k++;
    }
        
        var symbol1 = symbol.concat(" ").concat("SlowK");
        var symbol2 = symbol.concat(" ").concat("SlowD");

       
Highcharts.chart('container', {
        
      
plotOptions: {


    series: {
     marker: {
                        enabled: true,
                        symbol: 'circle',
                        radius: 2.5
            },
        color: '#ef2400'
  }
            
},
   
        title: {
            text: indicator
        },
        subtitle: {
            text: '<a href="https://www.alphavantage.co/" style="color: blue" target="_blank">Source: Alpha Vantage</a>'
        },
          xAxis: {      
         categories: processed_dates,
               reversed: true,
              tickInterval: 5
        },
        yAxis: {
            title: {
                text: yaxisData
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
       
        series: [{
            name:  symbol1,
            type: 'line',
            color: '#FF0000',
            data: processed_json_slowK
           
        },
       {
            name:  symbol2,
            type: 'line',
            color: '#ADDFFF',
            data: processed_json_slowD
        }
    ]
    });
        
}
        
function createChartWithJSONForThreeSeries(jsonObj) {
        
    var first = new Array();
    var second = new Array();   
    var third = new Array();  
        
    var symbol = jsonObj["Meta Data"]["1: Symbol"];   // MSFT, etc.
    var indicator = jsonObj["Meta Data"]["2: Indicator"]; 
    
    var indicatorSplitBySpace = indicator.split(" ");
    var symbolKey = indicatorSplitBySpace[indicatorSplitBySpace.length-1];
    
    var yaxisData = symbolKey.slice(1,-1);
    
    var indicatorData =Object.values(jsonObj)[1];
    
    var data = Object.values(Object.values(indicatorData));
    var dates = Object.keys(indicatorData);
    var processed_dates = new Array();
  
    
    var k = 0;

   for (i = 0; i < dates.length && k < 126; i++) {       
      var datestring = dates[i];
      var mm = datestring.substring(5,7);
      var dd = datestring.substring(8,10);
       var dateInMMDD = (mm.concat("/")).concat(dd);
      processed_dates.push(dateInMMDD);
       k++;
    }
    k = 0;
    
    

    for (i = 0; i < data.length && k < 126; i++) {
        var j = Object.values(data[i])[2];
        first.push(parseFloat((j).substring(0,5))); 
        j = Object.values(data[i])[1];
        second.push(parseFloat((j).substring(0,5))); 
        j = Object.values(data[i])[0];
        third.push(parseFloat((j).substring(0,5))); 
        k++;
    }
        
    
         var indicator1 =  Object.keys(data[0])[0];
          var indicator2 =   Object.keys(data[0])[1];
           var indicator3 =   Object.keys(data[0])[2];
     
        var symbol1 = symbol.concat(" ").concat(indicator1);
        
        var symbol2 = symbol.concat(" ").concat(indicator2);
        
        var symbol3 = symbol.concat(" ").concat(indicator3);
    
    
    if(yaxisData == "BBANDS") {
          var buff = first;
    first = second;
    
    second = buff; 
        
        var buff2 = symbol1;
        symbol1 = symbol2;
        symbol2 = buff2;
        
    }
    
 
    
      var color1 = '#FF0000';
      var color2 = '#000000';
      var color3 = '#008000';
    
    
    
    if(yaxisData == "MACD") {
        
        color2 = '#FFFF00';
    }

       
Highcharts.chart('container', {
        
        credits: {
        enabled: false
    },
    
    plotOptions: {


    series: {
     marker: {
                        enabled: true,
                        symbol: 'circle',
                        radius: 2.5
            },
        color: '#ef2400'
  }
            
},
   
  
        title: {
            text: indicator
        },
        subtitle: {
            text: '<a href="https://www.alphavantage.co/" style="color: blue" target="_blank">Source: Alpha Vantage</a>'
        },
          xAxis: {      
         categories: processed_dates,
               reversed: true,
              tickInterval: 5
        },
        yAxis: {
            title: {
                text: yaxisData
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
       
        series: [{
            name:  symbol1,
            type: 'line',
            color: color1,
            data: first,
           
        },
                 
                 {
            name:  symbol2,
            type: 'line',
            color: color2,
            data: second,
           
        },
                    {
            name:  symbol3,
            type: 'line',
            color: color3,
            data: third,
            
        }
                
    ]
    });
        
}
    
function createChartForStockPrice(jsonStockPrice) {
    
    var processed_json = new Array();
   
    var symbol = Object.values(jsonStockPrice["Meta Data"])[1];
    
  
    
   var companysymbolVol = symbol.concat(" Volume");
   
    var indicatorData =Object.values(jsonStockPrice)[1];
    
    
    var data = Object.values(Object.values(indicatorData));
    var dates = Object.keys(indicatorData);
    var processed_dates = new Array();
    var stock_price = new Array();
    var stock_volume = new Array();
    
    var k = 0;

   for (i = 0; i < dates.length && k < 200; i++) {  
       
      var datestring = dates[i];
      var mm = datestring.substring(5,7);
      var dd = datestring.substring(8,10);
      var dateInMMDD = (mm.concat("/")).concat(dd);
      processed_dates.push(dateInMMDD);
      k++;
    }
    
     k = 0;
  
    var maxY = 0;
    for (i = 0; i < data.length && k < 200; i++) {
        var j = Object.values(data[i])[3];
        stock_price.push(parseFloat((j).substring(0,5))); 
        
        var v = parseInt(j);
        
        j = parseInt(Object.values(data[i])[4]);
        
        
        if(j > maxY)
            maxY = j;
        
        stock_volume.push(j);
        k++;
    }
  
      maxY = maxY * 3;
      var datestring = dates[0];
      var yy = datestring.substring(0,4);
      var mm = datestring.substring(5,7);
      var dd = datestring.substring(8,10);
    
    
    var titleDate =  ("Stock Price").concat(" (");
        
    titleDate = titleDate.concat((mm.concat("/")).concat((dd.concat("/")).concat(yy)).concat(")")) ;
    
     Highcharts.chart('container', {
            title: {
                text: titleDate
            },

            subtitle: {
                text: '<a href="https://www.alphavantage.co/" style="color: blue" target="_blank">Source: Alpha Vantage</a>',
                useHTML: true
            },
        plotOptions: {
                series: {
                    label: {
                        connectorAllowed: false
                    },
                    marker: {
                        enabled: false,
                        symbol: 'circle',
                        radius: 1
                    },
                }
            },
   

            xAxis: {
                categories: processed_dates,
                tickInterval : 5,
                label: {
                    step: 1
                 },
                reversed: true,
            },

            yAxis: [{ //Primary yAxis
                title: {
                    text: 'Stock Price',
                }

            },{ //Secondary yAxis
                title: {
                    text: 'Volume',
                },
                opposite: true,
                max: maxY
            }],

            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },

            series: [{
                type: 'area',
                name: symbol,
                color: '#FF0000',
                data: stock_price
            },
            {
                type: 'column',
                name: companysymbolVol,
                yAxis: 1,
                color: '#FFFFFF',
                data: stock_volume
            }]

        });
    
}
    

function createChartWithJSON(jsonObj) {
    
    var processed_json = new Array();
    var symbol = jsonObj["Meta Data"]["1: Symbol"];   // MSFT, etc.
    var indicator = jsonObj["Meta Data"]["2: Indicator"]; 
    
    var indicatorData =Object.values(jsonObj)[1];
    
    var indicatorSplitBySpace = indicator.split(" ");
    var symbolKey = indicatorSplitBySpace[indicatorSplitBySpace.length-1];
    
    var yaxisData = symbolKey.slice(1,-1);
    var data = Object.values(Object.values(indicatorData));
    var dates = Object.keys(indicatorData);
    var processed_dates = new Array();
  
    
    var k = 0;
    var minY = 1000;

   for (i = 0; i < dates.length && k < 126; i++) {       
      var datestring = dates[i];
      var mm = datestring.substring(5,7);
      var dd = datestring.substring(8,10);
       var dateInMMDD = (mm.concat("/")).concat(dd);
      processed_dates.push(dateInMMDD);
       k++;
    }
    k = 0;

    for (i = 0; i < data.length && k < 126; i++) {
        var j = Object.values(data[i])[0];
        processed_json.push(parseFloat((j).substring(0,5))); 
        
       
        k++;
    }

       
Highcharts.chart('container', {
        
      
plotOptions: {


    series: {
     marker: {
                        enabled: true,
                        symbol: 'circle',
                        radius: 2.5
            },
        color: '#ef2400'
  }
            
},
   
        title: {
            text: indicator
        },
        subtitle: {
            text: '<a href="https://www.alphavantage.co/" style="color: blue" target="_blank">Source: Alpha Vantage</a>'
        },
          xAxis: {      
         categories: processed_dates,
               reversed: true,
              tickInterval: 5
        },
        yAxis: {
            title: {
                text: yaxisData
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
       
        series: [{
            name:  symbol,
            type: 'line',
            color: '#FF0000',
            data: processed_json
           
        }
    ]
    });
}

function submitForm(){
    var input = document.getElementById("input").value ;    
    // TODO: do the validation here.
    if(input == "") {
        alert("Please enter a symbol");
        return;
    } 
}
    
function resetForm(what){
    document.getElementById("input").value = "";
    document.getElementById("stockBlock").innerHTML  = "";
}    
    
</script> 
</head>

<body align = "center" width = "100%">
<div class = "textBody">
<h1 style="font-style: italic;text-align:center;font-size:20px; margin-bottom:0.05px; margin-top:0.1px">Stock Search</h1>
<hr>
<form method="post" onsubmit="return submitForm()" id="myForm">
    <div style="margin-top:0.05px;"> 
        <table class = "table1">
            <tr>
                <td>&nbsp; Enter Stock Ticker Symbol:*</td>
                <td><input   type="text" name="input" id = "input" value = "<?php echo isset($_POST["submit"]) ? $_POST["input"] : "" ?>" /> </td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="submit" value="Search" />
                    <input type="button" name="reset" value="Clear" onClick="resetForm(this.form)"> </td></tr> </table>
    </div>
    <div style = 'font-style: italic;text-align:left'> &nbsp; &nbsp;* - Mandatory fields </div>
</form>
</div> 
    <br>
<div class="stockTable" id="stockBlock">
    
    
   <?php 
    
    
    $data2 = "";
    if(isset($_POST["submit"]) && isset($_POST["input"]) && $_POST["input"] != "") {
        $symbol = $_POST["input"];
        $initialURL = "https://www.alphavantage.co/query?function=";
        
         $data1 = $initialURL . "TIME_SERIES_DAILY&symbol=" . $_POST["input"] . "&apikey=A2YO93CBH2X5ELC2" ;
        
         $result = file_get_contents("$data1", true);
        
         $var = json_decode($result,1);
        
      
        
        if(count($var) == 1) 
        {
            
        echo "<table class= 'table2' align = 'center'>";
        echo " <colgroup>";
        echo "<col span=1" . " " . "style=" . "\"background-color:" . "#F1F3F4\"" . "width = 30%" . ">";
        echo "<col span=1  width = \"70%\" align-content=\"center\" align= \"center\" >";
        echo "</colgroup>";
        echo "<tr>";
            echo "<td>Error</td>";
            echo "<td align= \"center\">Error: No record has been found, please enter a valid symbol</td>";
            echo "</tr>";   
            echo "</table>";
        }
     else {  
            
     
        $first = array_values($var['Time Series (Daily)']);
        
        
       
        $input = $_POST["input"];
        
        $smaURL = $initialURL . "SMA" . "&symbol=" . $_POST["input"] . "&interval=daily&time_period=10&series_type=close&apikey=A2YO93CBH2X5ELC2";
        
        $emaURL = $initialURL . "EMA" . "&symbol=" . $_POST["input"] . "&interval=daily&time_period=10&series_type=close&apikey=A2YO93CBH2X5ELC2";
        
        $rsiURL = $initialURL . "RSI" . "&symbol=" . $_POST["input"] . "&interval=daily&time_period=10&series_type=close&apikey=A2YO93CBH2X5ELC2";
        
        $adxURL = $initialURL . "ADX" . "&symbol=" . $_POST["input"] . "&interval=daily&time_period=10&series_type=close&apikey=A2YO93CBH2X5ELC2";
        
        $cciURL = $initialURL . "CCI" . "&symbol=" . $_POST["input"] . "&interval=daily&time_period=10&series_type=close&apikey=A2YO93CBH2X5ELC2";
        
        $stochURL = $initialURL . "STOCH" . "&symbol=" . $_POST["input"] . "&interval=daily&time_period=10&series_type=close&apikey=A2YO93CBH2X5ELC2";
        
        $bbandsURL = $initialURL . "BBANDS" . "&symbol=" . $_POST["input"] . "&interval=daily&time_period=10&series_type=close&apikey=A2YO93CBH2X5ELC2";
        
        $macdURL = $initialURL . "MACD" . "&symbol=" . $_POST["input"] . "&interval=daily&time_period=10&series_type=close&apikey=A2YO93CBH2X5ELC2";
        
        $smaData = file_get_contents($smaURL);
        
       // $smaData = file_get_contents("smaData.json");
        
        $emaData = file_get_contents($emaURL);
        
        //$emaData = file_get_contents("emaData.json");
        
        $rsiData = file_get_contents($rsiURL);
        
      //  $rsiData = file_get_contents("rsiData.json");
        
        $adxData = file_get_contents($adxURL);
        
       // $adxData = file_get_contents("adxData.json");
        
        $cciData = file_get_contents($cciURL);
        
       // $cciData = file_get_contents("cciData.json");
        
        
         $stochData = file_get_contents($stochURL);
        
      //   $stochData = file_get_contents("stochData.json");
        
         $bbandsData = file_get_contents($bbandsURL);
        
         //$bbandsData = file_get_contents("bbandsData.json");
        
         $macdData = file_get_contents($macdURL);
        
       //  $macdData = file_get_contents("macdData.json");
        
    
      
        echo "<table class= 'table2' align = 'center' onload = 'javascript:createChartForStockPrice($result)'>";
        echo " <colgroup>";
        echo "<col span=1" . " " . "style=" . "\"background-color:" . "#F1F3F4\"" . "width = 30%" . ">";
        echo "<col span=1  width = \"70%\" align-content=\"center\" align= \"center\" >";
        echo "</colgroup>";
        echo "<tr>";
            echo "<td>Stock Ticker Symbol</td>";
            echo "<td align= \"center\">$symbol</td>";
            echo "</tr>";   
        
            echo "<tr>";
            echo "<td>Close</td>";
            $close =  $first[0]['4. close'];
            echo "<td align= \"center\">$close</td>";
            echo "</tr>";   

            echo "<tr>";
            echo "<td>Open</td>";
            $open =  $first[0]['1. open'];
            echo "<td align= \"center\">$open</td>";
            echo "</tr>";   

            echo "<tr>";
            echo "<td>Previous Close</td>";
            $prevClose = $first[1]['4. close'];
            echo "<td align= \"center\">$prevClose</td>";
            echo "</tr>";   

            echo "<tr>";
            echo "<td>Change</td>";
            $change = $close - $prevClose;

            $change = number_format($close - $prevClose, 2, '.', '');
            $changeVal = abs($change);
            echo "<td align= \"center\">";
            if($change  < 0) {
                echo  $changeVal . "<img src = \"http://cs-server.usc.edu:45678/hw/hw6/images/Red_Arrow_Down.png\" style=\"width:13px;height:13px;\">";
            }
            else if($change > 0) {
                echo  $changeVal . "<img src = \"http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png\" style=\"width:13px;height:13px;\">";
            }
            else {
                echo  $changeVal . "+$0";
            }

            echo "</td>";
            echo "</tr>"; 

            echo "<tr>";
            echo "<td>Change Percent</td>";
                $k = ($changeVal/$prevClose) * 100;
                $k =   number_format($k, 2, '.', '')."%";
            echo "<td align= \"center\">";

            if($change  < 0) {
                echo  $k . "<img src = \"http://cs-server.usc.edu:45678/hw/hw6/images/Red_Arrow_Down.png\" style=\"width:13px;height:13px;\">";
            }
            else if($change > 0) {
                echo  $k . "<img src = \"http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png\" style=\"width:13px;height:13px;\">";
            }
            else {
                echo  $k . "+$0";
            }
        
      

            echo "</td>";
            echo "</tr>"; 
            echo "<tr>";
            echo "<td>Day's Range</td>";
            $low = $first[0]['3. low'];
            $high = $first[0]['2. high'];
            $range = $low . " - " . $high;
            echo "<td align= \"center\">$range</td>";
            echo "</tr>"; 

            echo "<tr>";
            echo "<td>Volume</td>";
            $volume = $first[0]['5. volume'];
            echo "<td align= \"center\">$volume</td>";
            echo "</tr>"; 

            echo "<tr>";
            echo "<td>Timestamp</td>";
            $timestamp = $var['Meta Data']['3. Last Refreshed'];

            echo "<td align= \"center\">$timestamp</td>";
            echo "</tr>";
        
            echo "<tr>";
            echo "<td>Indicators</td>";

            echo "<td align='center'><a href ='javascript:createChartForStockPrice($result)' onload = 'javascript:createChartForStockPrice($result);'>Price</a>"; 
      
            echo " &nbsp <a href ='javascript:createChartWithJSON($smaData)'>SMA</a>"; 
        
          
            echo " &nbsp <a href = 'javascript:createChartWithJSON($emaData)'>EMA</a>";
            echo " &nbsp <a href ='javascript:createChartWithJSONForStoch($stochData)'>STOCH</a>";
            echo " &nbsp <a href = 'javascript:createChartWithJSON($rsiData)' >RSI</a>";
            echo " &nbsp <a href = 'javascript:createChartWithJSON($adxData)' >ADX</a>";
            echo " &nbsp <a href = 'javascript:createChartWithJSON($cciData)' >CCI</a>";
          echo " &nbsp <a href = 'javascript:createChartWithJSONForThreeSeries($bbandsData)' >BBANDS</a>";
          echo " &nbsp <a href = 'javascript:createChartWithJSONForThreeSeries($macdData)' >MACD</a>";
            //echo " &nbsp <a href = \"\" >BBANDS</a>";
            //echo " &nbsp <a href = \"\" >MACD</a>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";

            $news = "https://seekingalpha.com/api/sa/combined/" . $_POST["input"]  . ".xml";
        
        
           
            $xml=simplexml_load_file($news) or die("Error: Cannot create object"); 
        
          $newsInfo = array(); 
          $find = 'article';
          $x = 0;
       
        foreach($xml->channel->item as $currentItem) {
            
            
              $newsLink = htmlspecialchars($currentItem->link->__toString());
            
              $pos = strpos($newsLink, $find);
            
            if ($pos !== false) {
                $newsHeadline = htmlspecialchars($xml->channel->item[$x]->title->__toString());
                $newsPubDate =htmlspecialchars($xml->channel->item[$x]->pubDate->__toString());
                $arr[$x] = array("title"=>$newsHeadline,"link"=>$newsLink ,"pubDate"=>$newsPubDate);
                  $x++;
            }
          
        }
        
        
      $jsonNews = json_encode($arr, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
     
        
        echo "<div id='container'  style='width:900px; margin:0 auto; float = center; border: 1px solid #E3E7EA;'></div>";
                           
      echo "<div id = 'newsToggle'>";
        echo "<span id = 'newsText' style='color:gray;font-size:15px'>click to show stock news</span>";
            echo "<br>";
        echo "<img src = 'http://cs-server.usc.edu:45678/hw/hw6/images/Gray_Arrow_Down.png' id='newsImage' onclick='showNews($jsonNews)' width = '35px' height = '14px'>";
        echo "</div>";
    
   echo  "<div id = 'container2'></div>"   ;
            
     }  }   ?>
  
<script>
    createChartForStockPrice(<?php echo $result ?>)</script>
        
          
</div>
   
 
</body>
    
</html>