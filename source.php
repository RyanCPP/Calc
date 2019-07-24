<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exchange Capital Road Accident Fund Calculator</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
	<link rel="stylesheet" href="styles.css" type="text/css">
  </head>

<body class="base">
    <div class="container-fluid">
		<div class="row base" style="height:20px"></div>
        <div class="row base" style="height:200px">
			<div class="col-md-2"></div>
			<div class="col-md-8" style="text-align: center">
				<img src="excapLogo.png" alt="Exchange Capital Logo" height="80%" width="50%">
			</div>
			<div class="col-md-2"></div>
		</div>
		<div class="row base" style="height:40px"></div>
        <div class="row calc" style="height:420px; border-left: 1px solid black; border-right: 1px solid black;  border-top: 1px solid black;"> <!-- border-bottom: 2px solid blue-->
            <div class="col-md-6">
                <p style="text-align:center; color: rgb(0,11,127)"><em><b>General Assumptions</em></b></p>
				<div class="row">	
					<form id="generalAssumptionsForm" style="margin-left: 33%">
					  Discount Rate (%):<br>
					  <input type="number" class="form-control" name="discountRate" id="discountRate" value="2.5" readOnly>
					  <br>
					  Inflation Rate (%):<br>
					  <input type="number" class="form-control" name="inflationRate" id="inflationRate" value="6" readOnly>
					  <br>
					  Investment Rate (%):<br>
					  <input type="number" class="form-control" name="investmentRate" id="investmentRate" value="8.65" readOnly>
					  <br>
					  Gender:<br>
					  <div class="row">
						  <div class="col-md-6" id="maleButton">
							<button class="btn btn-light" onclick="setGender(0)">Male</button>
						  </div>
						  <div class="col-md-6" id="femaleButton">
							<button class="btn btn-light" onclick="setGender(1)">Female</button>
						  </div>
					  </div>
					  <br>
					</form>
				</div>
            </div>
            <div class="col-md-6">
                <p style="text-align:center; color: rgb(0,11,127)"><em><b>General Details</em></b></p>
				<div class="row">	
					<form id="generalDetailsForm" style="margin-left: 33%">
					  Date of Birth:<br>
					  <input type="date" class="form-control" name="dateBirth" id="dateBirth">
					  <br>
					  <!--Year of Birth:<br>
					  <input type="number" name="yearBirth" id="yearBirth">
					  <br>-->
					  Date of Accident:<br>
					  <input type="date" class="form-control" name="dateAccident" id="dateAccident" onchange="calcYear()">
					  <br>
					  <!--Year of Accident:<br>
					  <input type="number" name="yearAccident" id="yearAccident">
					  <br>-->
					  <div id="calcYearDiv"></div>
					  <!--Year of Calculation:<br>
					  <input type="number" name="yearCalc" id="yearCalc" onchange="postEarningsSetup()">-->
					  <br>
					  <div class="row">
						  <div class="col-md-6" id="capButton">
							<button class="btn btn-light" onclick="setCap(1)">Cap</button>
						  </div>
						  <div class="col-md-6" id="noCapButton">
							<button class="btn btn-light" onclick="setCap(0)">No Cap</button>
						  </div>
					  </div>
					  <br>
					</form>
				</div>
            </div>       
        </div>
	</div>
	<!--<div class="container-fluid">
		<div class="row" style="height:10px; background-color: rgb(0,11,127)"></div>
	</div>-->
	<div class="container-fluid" style="border: 1px solid black">
        <div class="row calc" style="height:550px" id="earningsSection">
            <div class="col-md-6 calc" style="border-right: 1px solid black; text-align:center">
                <div class="row" style="margin: auto">
					<p style="text-align:center; color: rgb(0,11,127)"><em><b>Pre-Accident</b></em></p>
				</div>
				<div class="row">
					<form id="preAccidentForm" style="margin: auto">
					  Retirement Age:<br>
					  <input type="number" class="form-control" name="preAccidentRetirement" id="preAccidentRetirement" value="65">
					  <br>
					  Ceiling Age:<br>
					  <input type="number" class="form-control" name="preAccidentCeilingAge" id="preAccidentCeilingAge" value="45">
					  <br>
					  <div id="earningsAccidentWording">Earnings @ Accident:</div>
					  <!--Earnings @ Accident:<br>-->
					  <div id="preEarningsAccidentDiv" style="margin: auto">
						<button type="button" class="btn btn-info" style="width: 100%" title="Use this option for uniform increases in income between the accident and the ceiling" onclick="earningsType('simpleUniform')">Employed @ Accident</button>
						<button type="button" class="btn btn-info" style="width: 100%" title="Use this option for yearly input of income between the accident date and calculation date" onclick="earningsType('detailedYearly')">Detailed Yearly</button>
						<button type="button" class="btn btn-info" style="width: 100%" title="Use this option for if the claimant was unemployed at the time of the accident" onclick="earningsType('unemployed')">Unemployed @ Accident</button>
					  </div>
					  <!--<input type="number" class="form-control" name="preEarningsAccident" id="preEarningsAccident" onchange="earningsStartSetup('preEarningsAccident','earningsStartPre','Pre')"><div id="preEarningsAccidentPaterson"><button type="button" class="btn btn-info" style="width: 100%" title="Use this option if you would like to get Paterson values" onclick="paterson('preEarningsAccidentPaterson')">Paterson</button></div>
					  <div id="earningsStartPre"></div>-->
					  <br>
					  Earnings @ Ceiling:<br>
					  <input type="number" class="form-control" name="preEarningsCeiling" id="preEarningsCeiling"><div id="preEarningsCeilingPaterson"><button type="button" class="btn btn-info" style="width: 100%" title="Use this option if you would like to get Paterson values" onclick="paterson('preEarningsCeilingPaterson')">Paterson</button></div>
					</form>
				</div>
            </div>
			<!--<div class="col-md-2" style="background-color: rgb(254,254,254);"></div>-->
			<div class="col-md-6 calc" style="text-align:center">
                <div class="row" style="margin: auto">
					<p style="text-align:center; color: rgb(0,11,127)"><em><b>Post-Accident</b></em></p>
				</div>
				<div class="row">
					<form id="postAccidentForm" style="margin: auto">
					  Retirement Age:<br>
					  <input type="number" class="form-control" name="postAccidentRetirement" id="postAccidentRetirement"><button type="button" class="btn btn-info" style="width: 100%" title="Use this option if the claimant is unemployable from the calculation date" onclick="unemployable()">Unemployable</button>
					  <br>
					  <br>
					  Ceiling Age:<br>
					  <input type="number" class="form-control" name="postAccidentCeilingAge" id="postAccidentCeilingAge" value="45">
					  <br>
					  <div id="actualEarningsHeading"></div><!--Actual Earnings Since Accident:<br>-->
					  <div id="earningsStartPost"></div>
					  <!--<br>-->
					  <div id="postAccidentActuals"></div>
					  <br>
					  Earnings @ Ceiling:<br>
					  <input type="number" class="form-control" name="postEarningsCeiling" id="postEarningsCeiling"><div id="postEarningsCeilingPaterson"><button type="button" class="btn btn-info" style="width: 100%" id="postCeilingPatersonButton" title="Use this option if you would like to get Paterson values" onclick="paterson('postEarningsCeilingPaterson')">Paterson</button></div>
					</form>
				</div>
			</div>
        </div>
		<div class="row calc" style="height: 40px">
			<div class="col-md-6" style="text-align: center; border-right: 1px solid black">
				<input type="button" class="btn btn-secondary" onclick="clearAll(3)" style="margin: auto" value="Clear Pre-Accident Details">
			</div>
			<div class="col-md-6" style="text-align: center">
				<input type="button" class="btn btn-secondary" onclick="clearAll(2)" style="margin: auto" value="Clear Post-Accident Details">
			</div>
		</div>
		<div class="row calc" style="height: 5px">
			<div class="col-md-6" style="border-right: 1px solid black"></div>
			<div class="col-md-6"></div>
		</div>
	</div>
	<!--<div class="container-fluid base">
		<div class="row" style="height:40px"></div>
	</div>-->
	<!--<div class="container-fluid base">
		<div class="row" style="height:50px">
			<button class="btn btn-primary" onclick="calculate()" style="margin: auto">Calculate</button>
		</div>		
        <div class="row" style="height:50px">
            <input type="button" class="btn btn-secondary" onclick="clearAll(1)" style="margin: auto" value="Clear All">
        </div>
	</div>-->
	
	<div class="container-fluid">
		<div class="row calc" style="height:600px; border-bottom: 1px solid black; text-align: center; padding-top: 30px" id="resultsSection">
            <div class="col-md-12">
                <div class="row">
					<div class="col-md-12"> <!--style="border: 1px solid black"-->
						<div class="row">
							<form id="contingencies" style="margin: auto">
							  <div class="row" style="margin: auto">
								<p style="color: rgb(0,11,127)"><em><b>Contingencies</em></b></p>
							  </div>
							  <div class="row">
								<div class="col-md-6">
									Past Pre-Accident:<br>
									<input type="number" class="form-control" name="pastPreCon" id="pastPreCon" value="5">
								</div>
								<div class="col-md-6">
									Past Post-Accident:<br>
									<input type="number" class="form-control" name="pastPostCon" id="pastPostCon" value="5">
								</div>
							  </div>
							  <br>
							  <div class="row">
								<div class="col-md-6">
									Future Pre-Accident:<br>
									<input type="number" class="form-control" name="futurePreCon" id="futurePreCon" value="15">
								</div>
								<div class="col-md-6">
									Future Post-Accident:<br>
									<input type="number" class="form-control" name="futurePostCon" id="futurePostCon" value="20">
								</div>
							  </div>
							  
							  <br>
							  
							</form>
						</div>
						<br><br>
						<div class="row" style="height:50px">
							<button class="btn btn-primary" onclick="calculate()" style="margin: auto">Calculate</button>
						</div>		
						<div class="row" style="height:50px">
							<input type="button" class="btn btn-secondary" onclick="clearAll(1)" style="margin: auto" value="Clear All">
						</div>
					</div>
				</div>
				<div class="row" style="height:50px"></div>
				<p style="text-align: center; color: rgb(0,11,127)"><b>Results</b></p>
                <p style="text-align: center" id="preResult"></p>
                <p style="text-align: center" id="postResult"></p>
                <p style="text-align: center" id="totalResult"></p>
				<div class="row"">
					<button class="btn btn-primary" onclick="printResults()" style="margin: auto">Print Results</button>
				</div>
            </div>
        </div>
	</div>
	<div class="container-fluid">
        <div class="row base" style="height:100px"></div>
        <div class="row base" style="height:40px">
            <div class="col-md-5"></div>
            <div class="col-md-2" style="text-align: center">
                <a href="logout.php"><button type="button" class="btn btn-light">Logout</button></a>
            </div>
            <div class="col-md-5"></div>
        </div>
        <div class="row base" style="height:100px"></div>
		<div class="row base" style="height:20px">
			<div class="col-md-12" style="text-align: center; color: rgb(0,11,127)">
				<p><em>Exchange Capital - Invaluable Expertise</em></p>
			</div>
		</div>
    </div>

</body>

<script>
    var allForms = ["generalAssumptionsForm","generalDetailsForm","preAccidentForm","postAccidentForm"];
    var generalAssumptionsForm = ["generalAssumptionsForm"];
    var generalDetailsForm = ["generalDetailsForm"];
	var postPastEarningsEmptyState = "";
	var preAccidentEqualiser = 0;
	var ages = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70];
	var life2M = [1,0.9894,0.99841318,0.999078789,0.999169132,0.999290133,0.99950274,0.999563412,0.999634325,0.999695159,0.999776382,0.999806832,0.99976612,0.999664354,0.999521799,0.999328162,0.9991138,0.998878524,0.998632304,0.998385135,0.998157305,0.997959037,0.997800707,0.997692862,0.997625586,0.997619935,0.997635002,0.99769178,0.997738547,0.997816982,0.997843609,0.997838949,0.997813242,0.997755769,0.997687361,0.997597324,0.997496048,0.99737276,0.997227199,0.997048381,0.996846576,0.996599884,0.996329166,0.99602306,0.995669912,0.995268639,0.994828949,0.994316489,0.993751249,0.99310884,0.99239749,0.991591306,0.990685714,0.989686797,0.988588547,0.98737207,0.986040291,0.984583152,0.983013321,0.981318351,0.979496334,0.977544033,0.975443456,0.973200633,0.970807323,0.96823883,0.965510551,0.962624623,0.959583795,0.956375502,0.953003342];
	var life2F = [1,0.99257,0.998690269,0.999314011,0.999424585,0.999555565,0.999626104,0.999716946,0.999726978,0.999767362,0.999797659,0.999807737,0.999797579,0.999767169,0.999726613,0.999675897,0.999615003,0.999564177,0.999503148,0.999452177,0.999411275,0.999380459,0.999349587,0.999328825,0.999308022,0.999287176,0.999266287,0.999245352,0.999224371,0.999203342,0.999172042,0.999140665,0.999109209,0.999057174,0.999004996,0.998942397,0.998869325,0.998785721,0.998681215,0.99856599,0.998429622,0.998282285,0.99809275,0.9978814,0.997637533,0.997350275,0.997039904,0.996695411,0.996337112,0.995975026,0.995598125,0.995216432,0.994808059,0.994372047,0.9938965,0.993358159,0.992765696,0.992094687,0.991330573,0.99046892,0.989493131,0.988419377,0.987263878,0.986043127,0.984786077,0.98347517,0.98211586,0.980688844,0.97916002,0.977504366,0.975706667];
	var life5M = [1,0.94887,0.988660196,0.996386351,0.998545019,0.998553613,0.998905591,0.998979581,0.999000043,0.999160487,0.999493715,0.999590455,0.999568724,0.999428313,0.999201338,0.998898262,0.998529396,0.998115721,0.997678178,0.997226904,0.996782988,0.996356873,0.995959241,0.995590051,0.995282601,0.995015465,0.994800403,0.994638341,0.994530332,0.994420708,0.994377978,0.994334701,0.994267751,0.994164962,0.993978721,0.993706993,0.993347538,0.992933578,0.992475248,0.99199497,0.99151592,0.991025326,0.990485051,0.989892664,0.989220102,0.988437532,0.98757764,0.986609015,0.985537464,0.984381948,0.983148528,0.981815397,0.980400777,0.978924072,0.977376836,0.97577975,0.974093987,0.972339309,0.970472763,0.968512432,0.966444472,0.964234904,0.961899781,0.95941984,0.956812984,0.954059942,0.951138404,0.9480689,0.944855562,0.941481057,0.937954288];
	var life5F = [1,0.95459,0.989241454,0.99713021,0.998736207,0.999096149,0.999095331,0.999105164,0.999232311,0.999359768,0.999498163,0.99952996,0.999519051,0.999497434,0.99944369,0.99936845,0.999282363,0.99918538,0.999066714,0.998936993,0.998806875,0.998676309,0.998534467,0.998402814,0.998270551,0.998137621,0.99800397,0.997880412,0.997766982,0.997641896,0.997526892,0.99741106,0.997272357,0.997121525,0.996925187,0.996682717,0.996415651,0.996101125,0.995749406,0.995382103,0.994975955,0.994552547,0.99409962,0.993615993,0.993111911,0.992574546,0.992013999,0.991428808,0.990817362,0.990189934,0.989532874,0.988844063,0.988108713,0.987323607,0.986472358,0.985550142,0.984551427,0.983469863,0.982325216,0.981083429,0.979777113,0.978398692,0.976983522,0.97554095,0.974112472,0.972682341,0.971168363,0.969409759,0.967340886,0.964794381,0.961717538];
	var scales = {"UnskilledLQ":20700,"UnskilledM":36300,"UnskilledUQ":82000,"Semi-SkilledLQ":36300,"Semi-SkilledM":82000,"Semi-SkilledUQ":178000,"A1LQB":82000,"A1MB":98000,"A1UQB":118000,"A1LQT":106000,"A1MT":124000,"A1UQT":149000,"A2LQB":95000,"A2MB":111000,"A2UQB":133000,"A2LQT":122000,"A2MT":141000,"A2UQT":165000,"A3LQB":109000,"A3MB":127000,"A3UQB":152000,"A3LQT":140000,"A3MT":162000,"A3UQT":191000,"B1LQB":124000,"B1MB":147000,"B1UQB":172000,"B1LQT":166000,"B1MT":192000,"B1UQT":225000,"B2LQB":142000,"B2MB":168000,"B2UQB":192000,"B2LQT":186000,"B2MT":218000,"B2UQT":251000,"B3LQB":162000,"B3MB":187000,"B3UQB":214000,"B3LQT":210000,"B3MT":242000,"B3UQT":270000,"B4LQB":187000,"B4MB":213000,"B4UQB":248000,"B4LQT":243000,"B4MT":285000,"B4UQT":329000,"B5LQB":218000,"B5MB":249000,"B5UQB":300000,"B5LQT":291000,"B5MT":329000,"B5UQT":394000,"C1LQB":253000,"C1MB":300000,"C1UQB":358000,"C1LQT":356000,"C1MT":403000,"C1UQT":470000,"C2LQB":279000,"C2MB":326000,"C2UQB":385000,"C2LQT":378000,"C2MT":439000,"C2UQT":510000,"C3LQB":325000,"C3MB":371000,"C3UQB":439000,"C3LQT":457000,"C3MT":513000,"C3UQT":611000,"C4LQB":370000,"C4MB":437000,"C4UQB":522000,"C4LQT":536000,"C4MT":611000,"C4UQT":725000,"C5LQB":431000,"C5MB":509000,"C5UQB":601000,"C5LQT":634000,"C5MT":712000,"C5UQT":844000,"D1LQB":490000,"D1MB":583000,"D1UQB":682000,"D1LQT":733000,"D1MT":873000,"D1UQT":1047000,"D2LQB":565000,"D2MB":669000,"D2UQB":800000,"D2LQT":857000,"D2MT":998000,"D2UQT":1213000,"D3LQB":722000,"D3MB":836000,"D3UQB":1010000,"D3LQT":1065000,"D3MT":1224000,"D3UQT":1506000,"D4LQB":785000,"D4MB":912000,"D4UQB":1110000,"D4LQT":1156000,"D4MT":1332000,"D4UQT":1617000,"D5LQB":865000,"D5MB":1003000,"D51UQB":220000,"D5LQT":1271000,"D5MT":1468000,"D5UQT":1779000,"E1LQB":1407000,"E1MB":1798000,"E1UQB":2191000,"E1LQT":1775000,"E1MT":2506000,"E1UQT":3236000,"E2LQB":1734000,"E2MB":2207000,"E2UQB":2699000,"E2LQT":2326000,"E2MT":3207000,"E2UQT":4070000};
	var capDates = ['1950-01-01','2008-07-31','2008-12-31','2009-01-31','2009-04-30','2009-07-31','2009-10-31','2010-01-31','2010-04-30','2010-07-31','2010-10-31','2011-01-31','2011-04-30','2011-07-31','2011-10-31','2012-01-31','2012-04-30','2012-07-31','2012-10-31','2013-01-31','2013-04-30','2013-07-31','2013-10-31','2014-01-31','2014-04-30','2014-07-31','2014-10-31','2015-01-31','2015-04-30','2015-07-31','2015-10-31','2016-01-31','2016-04-30','2016-07-31','2016-10-31','2017-01-31','2017-04-30','2017-07-31','2017-10-31','2018-01-31','2018-04-30','2018-07-31','2018-10-31','2019-01-31'];
	var capLevels = [10000000,160000,166667,167071,169078,172806,175887,176535,178642,180750,182047,182857,185289,189017,191773,194043,196636,199716,201337,204904,207528,210192,213675,215320,219820,224120,227400,227810,228430,234366,237850,238670,244405,248710,251990,254450,259810,262366,263900,266200,270285,273863,276928,279994];
	var gend = 0;
	var capIndicator = 1;
	var unemployableVar = 1;
	var malLT = 250000;
	var femLT = 100000;
	var yearLT = 2011;
	var preEarningsMethod;
	var preAccidentCeilingGlobal;
	var preAccidentRetirementAgeGlobal;
	var accidentEarningsGlobal;
	var initialAgePreGlobal;
		

	
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
	
	function paterson(idee){
		var text1 = "<select class=\"form-control\" id=\"" + idee + 'Select' + "\" onchange=\"changeIncome('" + idee.substring(0,idee.length - 8) + "')\"><option disabled selected value> -- select an option -- </option><option value=\"UnskilledLQ\">Unskilled (Lower Quartile)</option><option value=\"UnskilledM\">Unskilled (Median)</option><option value=\"UnskilledUQ\">Unskilled (Upper Quartile)</option><option value=\"Semi-SkilledLQ\">Semi-Skilled (Lower Quartile)</option><option value=\"Semi-SkilledM\">Semi-Skilled (Median)</option><option value=\"Semi-SkilledUQ\">Semi-Skilled (Upper Quartile)</option><option value=\"A1LQB\">A1 Lower Quartile Basic</option><option value=\"A1MB\">A1 Median Basic</option><option value=\"A1UQB\">A1 Upper Quartile Basic</option><option value=\"A1LQT\">A1 Lower Quartile Total</option><option value=\"A1MT\">A1 Median Total</option><option value=\"A1UQT\">A1 Upper Quartile Total</option><option value=\"A2LQB\">A2 Lower Quartile Basic</option><option value=\"A2MB\">A2 Median Basic</option><option value=\"A2UQB\">A2 Upper Quartile Basic</option><option value=\"A2LQT\">A2 Lower Quartile Total</option><option value=\"A2MT\">A2 Median Total</option><option value=\"A2UQT\">A2 Upper Quartile Total</option><option value=\"A3LQB\">A3 Lower Quartile Basic</option><option value=\"A3MB\">A3 Median Basic</option><option value=\"A3UQB\">A3 Upper Quartile Basic</option><option value=\"A3LQT\">A3 Lower Quartile Total</option><option value=\"A3MT\">A3 Median Total</option><option value=\"A3UQT\">A3 Upper Quartile Total</option><option value=\"B1LQB\">B1 Lower Quartile Basic</option><option value=\"B1MB\">B1 Median Basic</option><option value=\"B1UQB\">B1 Upper Quartile Basic</option><option value=\"B1LQT\">B1 Lower Quartile Total</option><option value=\"B1MT\">B1 Median Total</option><option value=\"B1UQT\">B1 Upper Quartile Total</option><option value=\"B2LQB\">B2 Lower Quartile Basic</option><option value=\"B2MB\">B2 Median Basic</option><option value=\"B2UQB\">B2 Upper Quartile Basic</option><option value=\"B2LQT\">B2 Lower Quartile Total</option><option value=\"B2MT\">B2 Median Total</option><option value=\"B2UQT\">B2 Upper Quartile Total</option><option value=\"B4LQB\">B4 Lower Quartile Basic</option><option value=\"B4MB\">B4 Median Basic</option><option value=\"B4UQB\">B4 Upper Quartile Basic</option><option value=\"B4LQT\">B4 Lower Quartile Total</option><option value=\"B4MT\">B4 Median Total</option><option value=\"B4UQT\">B4 Upper Quartile Total</option><option value=\"B3LQB\">B3 Lower Quartile Basic</option><option value=\"B3MB\">B3 Median Basic</option><option value=\"B3UQB\">B3 Upper Quartile Basic</option><option value=\"B3LQT\">B3 Lower Quartile Total</option><option value=\"B3MT\">B3 Median Total</option><option value=\"B3UQT\">B3 Upper Quartile Total</option><option value=\"C1LQB\">C1 Lower Quartile Basic</option><option value=\"C1MB\">C1 Median Basic</option><option value=\"C1UQB\">C1 Upper Quartile Basic</option><option value=\"C1LQT\">C1 Lower Quartile Total</option><option value=\"C1MT\">C1 Median Total</option><option value=\"C1UQT\">C1 Upper Quartile Total</option><option value=\"B5LQB\">B5 Lower Quartile Basic</option><option value=\"B5MB\">B5 Median Basic</option><option value=\"B5UQB\">B5 Upper Quartile Basic</option><option value=\"B5LQT\">B5 Lower Quartile Total</option><option value=\"B5MT\">B5 Median Total</option><option value=\"B5UQT\">B5 Upper Quartile Total</option><option value=\"C2LQB\">C2 Lower Quartile Basic</option><option value=\"C2MB\">C2 Median Basic</option><option value=\"C2UQB\">C2 Upper Quartile Basic</option><option value=\"C2LQT\">C2 Lower Quartile Total</option><option value=\"C2MT\">C2 Median Total</option><option value=\"C2UQT\">C2 Upper Quartile Total</option><option value=\"C3LQB\">C3 Lower Quartile Basic</option><option value=\"C3MB\">C3 Median Basic</option><option value=\"C3UQB\">C3 Upper Quartile Basic</option><option value=\"C3LQT\">C3 Lower Quartile Total</option><option value=\"C3MT\">C3 Median Total</option><option value=\"C3UQT\">C3 Upper Quartile Total</option><option value=\"C4LQB\">C4 Lower Quartile Basic</option><option value=\"C4MB\">C4 Median Basic</option><option value=\"C4UQB\">C4 Upper Quartile Basic</option><option value=\"C4LQT\">C4 Lower Quartile Total</option><option value=\"C4MT\">C4 Median Total</option><option value=\"C4UQT\">C4 Upper Quartile Total</option><option value=\"C5LQB\">C5 Lower Quartile Basic</option><option value=\"C5MB\">C5 Median Basic</option><option value=\"C5UQB\">C5 Upper Quartile Basic</option><option value=\"C5LQT\">C5 Lower Quartile Total</option><option value=\"C5MT\">C5 Median Total</option><option value=\"C5UQT\">C5 Upper Quartile Total</option><option value=\"D1LQB\">D1 Lower Quartile Basic</option><option value=\"D1MB\">D1 Median Basic</option><option value=\"D1UQB\">D1 Upper Quartile Basic</option><option value=\"D1LQT\">D1 Lower Quartile Total</option><option value=\"D1MT\">D1 Median Total</option><option value=\"D1UQT\">D1 Upper Quartile Total</option><option value=\"D2LQB\">D2 Lower Quartile Basic</option><option value=\"D2MB\">D2 Median Basic</option><option value=\"D2UQB\">D2 Upper Quartile Basic</option><option value=\"D2LQT\">D2 Lower Quartile Total</option><option value=\"D2MT\">D2 Median Total</option><option value=\"D2UQT\">D2 Upper Quartile Total</option><option value=\"D3LQB\">D3 Lower Quartile Basic</option><option value=\"D3MB\">D3 Median Basic</option><option value=\"D3UQB\">D3 Upper Quartile Basic</option><option value=\"D3LQT\">D3 Lower Quartile Total</option><option value=\"D3MT\">D3 Median Total</option><option value=\"D3UQT\">D3 Upper Quartile Total</option><option value=\"D4LQB\">D4 Lower Quartile Basic</option><option value=\"D4MB\">D4 Median Basic</option><option value=\"D4UQB\">D4 Upper Quartile Basic</option><option value=\"D4LQT\">D4 Lower Quartile Total</option><option value=\"D4MT\">D4 Median Total</option><option value=\"D4UQT\">D4 Upper Quartile Total</option><option value=\"D5LQB\">D5 Lower Quartile Basic</option><option value=\"D5MB\">D5 Median Basic</option><option value=\"D5UQB\">D5 Upper Quartile Basic</option><option value=\"D5LQT\">D5 Lower Quartile Total</option><option value=\"D5MT\">D5 Median Total</option><option value=\"D5UQT\">D5 Upper Quartile Total</option><option value=\"E1LQB\">E1 Lower Quartile Basic</option><option value=\"E1MB\">E1 Median Basic</option><option value=\"E1UQB\">E1 Upper Quartile Basic</option><option value=\"E1LQT\">E1 Lower Quartile Total</option><option value=\"E1MT\">E1 Median Total</option><option value=\"E1UQT\">E1 Upper Quartile Total</option><option value=\"E2LQB\">E2 Lower Quartile Basic</option><option value=\"E2MB\">E2 Median Basic</option><option value=\"E2UQB\">E2 Upper Quartile Basic</option><option value=\"E2LQT\">E2 Lower Quartile Total</option><option value=\"E2MT\">E2 Median Total</option><option value=\"E2UQT\">E2 Upper Quartile Total</option></select>";
		document.getElementById(idee).innerHTML = text1;
	}

	function changeIncome(id1){
		var income;
		var level = document.getElementById(id1 + 'PatersonSelect').value;
		
		income = scales[level];
			
		document.getElementById(id1).value = income;
	}

/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
	
	function getDays(firstDay, secondDay){
		var oneDay = 24*60*60*1000;
		
		return Math.round(Math.abs(firstDay.getTime() - secondDay.getTime()) / oneDay);
	}
    
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/

    function calcYear(){
        var calcDateText = "";
        //calcYearText = "Year of Calculation:<br><input type=\"number\" name=\"yearCalc\" id=\"yearCalc\" onchange=\"postEarningsSetup()\">";
		calcDateText = "Date of Calculation:<br><input type=\"date\" class=\"form-control\" name=\"dateCalculation\" id=\"dateCalculation\" onchange=\"postEarningsSetup('post')\">";
        document.getElementById("calcYearDiv").innerHTML = calcDateText;
    }

/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/


	function earningsStartSetup(earningsID, divID, prePost){
		var earnings1 = parseFloat(document.getElementById(earningsID).value);
		if(prePost == "Pre" && (earnings1 == 0 || isNaN(earnings1))){
			document.getElementById(divID).innerHTML = "<div class=\"row\"><div class=\"col-md-6\">Initial Earnings:<br><input type=\"number\" class=\"form-control\" name=\"initialEarnings" + prePost + "\" id=\"initialEarnings" + prePost + "\"></div><div class=\"col-md-6\">Age:<br><input type=\"number\" class=\"form-control\" name=\"initialAge" + prePost + "\" id=\"initialAge" + prePost + "\"></div></div>";
		}
		if(prePost == "Post" && earnings1 == 0){
			document.getElementById(divID).innerHTML = "<div class=\"row\"><div class=\"col-md-6\">Initial Earnings:<br><input type=\"number\" class=\"form-control\" name=\"initialEarnings" + prePost + "\" id=\"initialEarnings" + prePost + "\"></div><div class=\"col-md-6\">Age:<br><input type=\"number\" class=\"form-control\" name=\"initialAge" + prePost + "\" id=\"initialAge" + prePost + "\"></div></div>";
		}
		
	}


/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/

    function postEarningsSetup(prePost1){
        var earningsText = "";
		var prePost2 = "";
		if(prePost1 == 'pre'){
			var divUsed = "preEarningsAccidentDiv";
			prePost2 = "pre";
		}
		else if(prePost1 == 'post'){
			var divUsed = "postAccidentActuals";
			prePost2 = "past";
		}
        document.getElementById("earningsSection").style.height = "550px";
        document.getElementById(divUsed).innerHTML = "";
        //var yearAcc = parseFloat(document.getElementById("yearAccident").value);
        //var yearCalc = parseFloat(document.getElementById("yearCalc").value);
        var dateAcc = new Date(document.getElementById("dateAccident").value);
		var dateCalc = new Date(document.getElementById("dateCalculation").value);
		var yearAcc = dateAcc.getFullYear();
		var yearCalc = dateCalc.getFullYear();
		
		
        var pastPeriods = yearCalc - yearAcc + 1;
		
		if(pastPeriods < 0){
			pastPeriods = 0;
		}

        for (i = 0; i < pastPeriods; i++){
            earningsText += (yearAcc + i) + " <input type=\"number\" name=\"" + prePost2 + "Earnings" + i + "\" id=\"" + prePost2 + "Earnings" + i + "\"><br>";
        }
		
		//alert("DivUsed = " + divUsed);
		//alert("prePost1 = " + prePost1);
		//alert("prePost2 = " + prePost2);
		
		if(prePost1 == 'end' || prePost1 == 'post'){
			earningsText += "<button type=\"button\" class=\"btn btn-info\" style=\"width: 100%\" title=\"Use this option if you would like to make earnings similar to pre-accident\" onclick=\"preEarnings(" + pastPeriods + "," + yearAcc + ")\">Pre-Accident</button>";
		}
		
        document.getElementById(divUsed).innerHTML = earningsText;
		postPastEarningsEmptyState = earningsText;
        document.getElementById("earningsSection").style.height = (570 + pastPeriods*26) + "px";
		document.getElementById("actualEarningsHeading").innerHTML = "Actual Earnings Since Accident:";
		prePost1 = "end";
    }

/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/

	function unemployable(){
		unemployableVar = 1 - unemployableVar;
		if(unemployableVar == 0){
			document.getElementById("postAccidentCeilingAge").style.backgroundColor = "grey";
			document.getElementById("postAccidentRetirement").style.backgroundColor = "grey";
			document.getElementById("postEarningsCeiling").style.backgroundColor = "grey";
			document.getElementById("postAccidentCeilingAge").readOnly = true;
			document.getElementById("postAccidentRetirement").readOnly = true;
			document.getElementById("postEarningsCeiling").readOnly = true;
			document.getElementById("postAccidentCeilingAge").value = "";
			document.getElementById("postAccidentRetirement").value = "";
			document.getElementById("postEarningsCeiling").value = "";
			document.getElementById("postCeilingPatersonButton").disabled = true;
		}
		else {
			document.getElementById("postAccidentCeilingAge").style.backgroundColor = "white";
			document.getElementById("postAccidentRetirement").style.backgroundColor = "white";
			document.getElementById("postEarningsCeiling").style.backgroundColor = "white";
			document.getElementById("postAccidentCeilingAge").readOnly = false;
			document.getElementById("postAccidentRetirement").readOnly = false;
			document.getElementById("postEarningsCeiling").readOnly = false;
			document.getElementById("postAccidentCeilingAge").value = "45";
			document.getElementById("postAccidentRetirement").value = "";
			document.getElementById("postEarningsCeiling").value = "";
			document.getElementById("postCeilingPatersonButton").disabled = false;
		}
		
	}


/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/

	function preEarnings(pastTime,yearAcc1){
		earningsStartSetup("pastEarnings" + (pastTime - 1),"earningsStartPost","Post");
		var postEarningsText = "";
		for (i = 0; i < pastTime; i++){
            postEarningsText += (yearAcc1 + i) + " <input type=\"number\" name=\"pastEarnings" + i + "\" id=\"pastEarnings" + i + "\" style=\"background-color: grey\" readonly><br>";
        }
		document.getElementById("postAccidentActuals").innerHTML = postEarningsText;
		preAccidentEqualiser = 1;
	}


/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/

	function dateCheck(date1){
		return date1 instanceof Date && !isNaN(date1);
	}

	

/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/

	function setGender(gender){
		if(gender == 0){
			gend = 0;
			document.getElementById("maleButton").innerHTML = "<button class=\"btn btn-dark\" onclick=\"setGender(0)\">Male</button>";
			document.getElementById("femaleButton").innerHTML = "<button class=\"btn btn-light\" onclick=\"setGender(1)\">Female</button>";
		}
		else if(gender == 1){
			gend = 1;
			document.getElementById("femaleButton").innerHTML = "<button class=\"btn btn-dark\" onclick=\"setGender(1)\">Female</button>";
			document.getElementById("maleButton").innerHTML = "<button class=\"btn btn-light\" onclick=\"setGender(0)\">Male</button>";
		}
	}

/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/

	function setCap(cap1){
		if(cap1 == 1){
			capIndicator = 1;
			document.getElementById("capButton").innerHTML = "<button class=\"btn btn-dark\" onclick=\"setCap(1)\">Cap</button>";
			document.getElementById("noCapButton").innerHTML = "<button class=\"btn btn-light\" onclick=\"setCap(0)\">No Cap</button>";
		}
		else if(cap1 == 0){
			capIndicator = 0;
			document.getElementById("noCapButton").innerHTML = "<button class=\"btn btn-dark\" onclick=\"setCap(0)\">No Cap</button>";
			document.getElementById("capButton").innerHTML = "<button class=\"btn btn-light\" onclick=\"setCap(1)\">Cap</button>";
		}
	}

/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/

	function earningsType(method){
		if(method == 'simpleUniform'){
			document.getElementById("preEarningsAccidentDiv").innerHTML = "<input type=\"number\" class=\"form-control\" name=\"preEarningsAccident\" id=\"preEarningsAccident\" onchange=\"earningsStartSetup('preEarningsAccident','earningsStartPre','Pre')\"><div id=\"preEarningsAccidentPaterson\"><button type=\"button\" class=\"btn btn-info\" style=\"width: 100%\" title=\"Use this option if you would like to get Paterson values\" onclick=\"paterson('preEarningsAccidentPaterson')\">Paterson</button></div>";
			document.getElementById("preAccidentForm").style.margin = "auto";
			preEarningsMethod = 1;
		}
		else if(method == 'detailedYearly'){
			postEarningsSetup('pre');
			preEarningsMethod = 2;
		}
		else if(method == 'unemployed'){
			document.getElementById("preEarningsAccidentDiv").innerHTML = "<input type=\"number\" class=\"form-control\" name=\"preEarningsAccident\" id=\"preEarningsAccident\" onchange=\"earningsStartSetup('preEarningsAccident','earningsStartPre','Pre')\"><div id=\"preEarningsAccidentPaterson\"><button type=\"button\" class=\"btn btn-info\" style=\"width: 100%\" title=\"Use this option if you would like to get Paterson values\" onclick=\"paterson('preEarningsAccidentPaterson')\">Paterson</button></div><br>Age of Employment<br><input type=\"number\" class=\"form-control\" name=\"preEarningsStartAge\" id=\"preEarningsStartAge\">";
			document.getElementById("earningsAccidentWording").innerHTML = "Initial Earnings";
			document.getElementById("preAccidentForm").style.margin = "auto";
			preEarningsMethod = 3;
		}
		
	}


/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/

	function taxCalc(earnings1){
		var rebate = 14220;
		var rate = 0;
		var base = 0;
		var calc1 = 0;
		var bound = 0;
		
		if(earnings1 <= 195850){
			bound = 0;
			rate = 0.18;
			base = 0;
		}
		else if(earnings1 > 195850 && earnings1 <= 305850){
			bound = 195850;
			rate = 0.26;
			base = 35253;
		}
		else if(earnings1 > 305850 && earnings1 <= 423300){
			bound = 305850;
			rate = 0.31;
			base = 63853;
		}
		else if(earnings1 > 423300 && earnings1 <= 555600){
			bound = 423300;
			rate = 0.36;
			base = 100263;
		}
		else if(earnings1 > 555600 && earnings1 <= 708310){
			bound = 555600;
			rate = 0.39;
			base = 147891;
		}
		else if(earnings1 > 708310 && earnings1 <= 1500000){
			bound = 708310;
			rate = 0.41;
			base = 207448;
		}
		else if(earnings1 > 1500000){
			bound = 1500000;
			rate = 0.45;
			base = 532041;
		}
		
		calc1 = (earnings1 - bound) * rate + base - rebate;
		
		if(calc1 < 0)
			return 0;
		else
			return calc1;
		
	}


/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/


    function calculate(){
        
        var dateBirth = new Date(document.getElementById("dateBirth").value);
		var dateAcc = new Date(document.getElementById("dateAccident").value);
		var dateCalc = new Date(document.getElementById("dateCalculation").value);
		var yearBirth = dateBirth.getFullYear();
		var yearAcc = dateAcc.getFullYear();
		var yearCalc = dateCalc.getFullYear();
		var discountRate = 1 + parseFloat(document.getElementById("discountRate").value)/100;
		var inflation = 1 + parseFloat(document.getElementById("inflationRate").value)/100;
		var pastPreCon = parseFloat(document.getElementById("pastPreCon").value)/100;
		var pastPostCon = parseFloat(document.getElementById("pastPostCon").value)/100;
		var futurePreCon = parseFloat(document.getElementById("futurePreCon").value)/100;
		var futurePostCon = parseFloat(document.getElementById("futurePostCon").value)/100;
		var eoyAcc = new Date(yearAcc,12,31);
		var boyCalc = new Date(yearCalc,1,1);
		var accidentPeriod = getDays(eoyAcc,dateAcc) / 365;
		var calcPeriod1 = getDays(boyCalc,dateCalc) / 365;
		var periodMultiplier = 1;
		var calcPeriod2 = 1 - calcPeriod1;
		var cap = 0;
		var errorMessage = "";
		var errorVariable = 0;
		
		if (preEarningsMethod == 1){
			var accidentEarnings = parseFloat(document.getElementById("preEarningsAccident").value);
		}
		else if(preEarningsMethod == 2){
			if(isNaN(parseFloat(document.getElementById("preEarnings0").value))){
				alert("Please complete the pre-accident earnings form.");
				return;
			}
			else {
				var accidentEarnings = parseFloat(document.getElementById("preEarnings0").value);
			}
		}
		else if(preEarningsMethod == 3){
			if(isNaN(parseFloat(document.getElementById("preEarningsAccident").value)) || isNaN(parseFloat(document.getElementById("preEarningsStartAge").value))){
				alert("Please complete the pre-accident earnings form.");
				return;
			}
			else {
				var accidentEarnings = parseFloat(document.getElementById("preEarningsAccident").value);
			}
		}
		
		
		//console.log(dateBirth);
		//console.log(dateAcc);
		//console.log(dateCalc);
		//var yearAcc = parseFloat(document.getElementById("yearAccident").value);
        //var yearCalc = parseFloat(document.getElementById("yearCalc").value);
        //var yearBirth = parseFloat(document.getElementById("yearBirth").value);
		
		if(dateCheck(dateBirth)){
			//alert("valid birth");
		}
		else {
			errorMessage = "Birth Date is an invalid date. Please supply a valid date.";
			errorVariable = 1;
			alert(errorMessage);
		}
		if(dateCheck(dateAcc) && dateAcc > dateBirth){
			//alert("valid acc");
		}
		else {
			errorMessage = "Accident Date is an invalid date. Please supply a valid date.";
			errorVariable = 1;
			alert(errorMessage);
		}
		if(dateCheck(dateCalc) && dateCalc > dateAcc){
			//alert("valid calc");
		}
		else {
			errorMessage = "Calculation Date is an invalid date. Please supply a valid date.";
			errorVariable = 1;
			alert(errorMessage);
		}

		
		document.getElementById("resultsSection").style.height = "550px";
		
		/*---------------------------------------------------------------------------------------------------------------*/
		// START PRE-ACCIDENT
		/*---------------------------------------------------------------------------------------------------------------*/
        var preAccidentCeiling = parseFloat(document.getElementById("preEarningsCeiling").value);
        var preAccidentCeilingAge = parseFloat(document.getElementById("preAccidentCeilingAge").value);
        var preAccidentRetirementAge = parseFloat(document.getElementById("preAccidentRetirement").value);
		var preAccidentRetirementDate = new Date(yearAcc + Math.ceil(preAccidentRetirementAge - (yearAcc-yearBirth)),dateBirth.getMonth(),dateBirth.getDate());
		var preAccidentCeilingError = "Please supply a valid pre-accident ceiling.";
		var preAccidentCeilingAgeError = "Please supply a valid pre-accident ceiling age.";
		var preAccidentRetirementAgeError = "Please supply a valid pre-accident retirement age.";
		var accidentEarningsError = "Please supply valid earnings at the time of the accident.";
		var boyPreRetire = new Date(preAccidentRetirementDate.getFullYear(),1,1);
        var periods = Math.ceil(preAccidentRetirementAge - (yearAcc - yearBirth) + 1);
        var income = new Array();
        var age = new Array();
        var year = new Array();
        var tax = new Array();
        var discount = new Array();
        var survival = new Array();
		var preCapResults = new Array();
		var contingency = new Array();
        var result = 0;
        //var annualIncrease = (preAccidentCeiling - accidentEarnings) / (preAccidentCeilingAge - (yearAcc - yearBirth));
		var preRetirePeriod = getDays(preAccidentRetirementDate,boyPreRetire) / 365;
		var debugVariable1 = 0;
		var initialEarningsPre = 0;
		var lifeTable = new Array();
		
		if(isNaN(accidentEarnings))
		{
			alert(accidentEarningsError);
			errorVariable = 1;
		}
		if(isNaN(preAccidentCeiling))
		{
			alert(preAccidentCeilingError);
			errorVariable = 1;
		}
		if(isNaN(preAccidentCeilingAge))
		{
			alert(preAccidentCeilingAgeError);
			errorVariable = 1;
		}
		if(isNaN(preAccidentRetirementAge))
		{
			alert(preAccidentRetirementAgeError);
			errorVariable = 1;
		}
		
		
		
		
		if(errorVariable == 1){
			return;
		}
		
		var capCounter = 0;
		for(i = 0; i < capLevels.length; i++){
			var placeHolderCapDate = new Date(capDates[i]);
			if(+dateAcc > +placeHolderCapDate){
				capCounter += 1;
			}
		}
		if(capIndicator == 1){
			cap = capLevels[capCounter - 1];
		}
		else if (capIndicator == 0){
			cap = 100000000;
		}
		
		
		if(gend == 0 && preAccidentCeiling >= malLT * Math.pow(inflation,yearCalc-yearLT)){
			lifeTable = life2M.slice(0);
		}
		else if(gend == 0 && preAccidentCeiling < malLT * Math.pow(inflation,yearCalc-yearLT)){
			lifeTable = life5M.slice(0);
		}
		else if(gend == 1 && preAccidentCeiling >= femLT * Math.pow(inflation,yearCalc-yearLT)){
			lifeTable = life2F.slice(0);
		}
		else if(gend == 1 && preAccidentCeiling < femLT * Math.pow(inflation,yearCalc-yearLT)){
			lifeTable = life5F.slice(0);
		}
		
		
		
		if (preEarningsMethod == 1){
			var annualIncrease = (preAccidentCeiling - accidentEarnings) / (preAccidentCeilingAge - (yearAcc - yearBirth));
			initialEarningsPre = accidentEarnings;
			initialAgePre = yearAcc-yearBirth;
		}
		else if(preEarningsMethod == 2){
			if(isNaN(parseFloat(document.getElementById("preEarnings" + (yearCalc - yearAcc)).value))){
				alert("Please complete the pre-accident earnings form.");
				return;
			}
			else {
				var annualIncrease = (preAccidentCeiling - parseFloat(document.getElementById("preEarnings" + (yearCalc - yearAcc)).value)) / (preAccidentCeilingAge - (yearCalc - yearBirth));
			}
		}
		else if(preEarningsMethod == 3){
			initialEarningsPre = accidentEarnings;
			initialAgePre = parseFloat(document.getElementById("preEarningsStartAge").value);
			var annualIncrease = (preAccidentCeiling - initialEarningsPre) / (preAccidentCeilingAge - initialAgePre);
		}
		
		for (i = 0; i < periods; i++){
			age[i] = i + yearAcc - yearBirth;
			
			year[i] = yearAcc + i; 
			
			if(year[i] <= yearCalc){
				contingency[i] = pastPreCon;
			}
			else {
				contingency[i] = futurePreCon;
			}

			
			
			if(preEarningsMethod == 1 || preEarningsMethod == 3){
				if(age[i] < initialAgePre){
					income[i] = 0;
				}
				else {
					if(age[i] == initialAgePre){
						income[i] = initialEarningsPre;
					}
					else {
						if(age[i] > preAccidentCeilingAge){
							income[i] = income[i-1];
						}
						else {
							income[i] = initialEarningsPre + annualIncrease * (age[i] - initialAgePre);
						}
						
					}
				}
			}
			else if(preEarningsMethod == 2){
				if(age[i] <= yearCalc - yearBirth){
					if(isNaN(parseFloat(document.getElementById("preEarnings" + i).value))){
						alert("Please complete the pre-accident earnings form.");
						return;
					}
					else {
					income[i] = parseFloat(document.getElementById("preEarnings" + i).value);
					}
				}
				else if(age[i] > preAccidentCeilingAge){
					income[i] = income[i-1];
				}
				else if(age[i] > yearCalc - yearBirth && age[i] <= preAccidentCeilingAge){
					income[i] = parseFloat(document.getElementById("preEarnings" + (yearCalc - yearAcc)).value) + annualIncrease * (age[i] - (yearCalc - yearBirth));
				}
			}
			
			
			

			tax[i] = taxCalc(income[i]);
			
			if(year[i] < yearCalc){
				survival[i] = 1;
				discount[i] = 1 / (Math.pow(inflation,yearCalc-year[i]));
			}            
			else {
				discount[i] = 1 / (Math.pow(discountRate,year[i]-yearCalc+2));
				
				if(yearAcc == yearCalc && i == 0){
					survival[i] = lifeTable[ages.indexOf(age[i])];
				}
				else {
					survival[i] = survival[i-1] * lifeTable[ages.indexOf(age[i])];
				}
				
			}

			if(year[i] == yearAcc){
				periodMultiplier = accidentPeriod;
			}
			else if(periods - i == 1){
				periodMultiplier = 0.5;
			}
			else{
				periodMultiplier = 1;
			}

			result += (income[i] - tax[i]) * discount[i] * survival[i] * periodMultiplier;
			preCapResults[i] = (income[i] - tax[i]) * discount[i] * survival[i] * periodMultiplier;
			//console.log("BF Year " + year[i] + " R" + income[i] + " discount = " + discount[i] + " tax = R" tax[i]);
			console.log("BF Year " + year[i] + " income = " + income[i] + " discount = " + discount[i] + " tax = R " + tax[i] + " survival = " + survival[i] + " multiplier = " + periodMultiplier + " NPV = " + ((income[i] - tax[i]) * discount[i] * survival[i] * periodMultiplier));
			
		}

		//document.getElementById("preResult").innerHTML = "Pre-Accident =  R " + result.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

		preAccidentCeilingGlobal = preAccidentCeiling;
		preAccidentRetirementAgeGlobal = preAccidentRetirementAge;
		accidentEarningsGlobal = accidentEarnings;
		initialAgePreGlobal = initialAgePre;
	
		/*---------------------------------------------------------------------------------------------------------------*/
		// END PRE-ACCIDENT
		/*---------------------------------------------------------------------------------------------------------------*/


		/*---------------------------------------------------------------------------------------------------------------*/
		// START POST-ACCIDENT
		/*---------------------------------------------------------------------------------------------------------------*/
		var postAccidentCeiling = parseFloat(document.getElementById("postEarningsCeiling").value);
		var postAccidentCeilingAge = parseFloat(document.getElementById("postAccidentCeilingAge").value);
		var postAccidentRetirementAge = parseFloat(document.getElementById("postAccidentRetirement").value);
		var postAccidentCeilingError = "Please supply a valid post-accident ceiling.";
		var postAccidentCeilingAgeError = "Please supply a valid post-accident ceiling age.";
		var postAccidentRetirementAgeError = "Please supply a valid post-accident retirement age.";
		var postErrorVariable = 0;
		
		if(isNaN(postAccidentCeiling) && unemployableVar != 0)
		{
			alert(postAccidentCeilingError);
			postErrorVariable = 1;
		}
		if(isNaN(postAccidentCeilingAge) && unemployableVar != 0)
		{
			alert(postAccidentCeilingAgeError);
			postErrorVariable = 1;
		}
		if(isNaN(postAccidentRetirementAge) && unemployableVar != 0)
		{
			alert(postAccidentRetirementAgeError);
			postErrorVariable = 1;
		}
		
		if(postErrorVariable == 1){
			return;
		}
		
		if(preAccidentEqualiser == 1){
			var earningsAtCalc = income[(yearCalc - yearAcc)];
		}
		else {
			var earningsAtCalc = parseFloat(document.getElementById("pastEarnings" + (yearCalc - yearAcc)).value);
		}
		
		
		if(unemployableVar == 0){
			postAccidentCeiling = earningsAtCalc;
			postAccidentCeilingAge = yearCalc - yearBirth + 1;
			postAccidentRetirementAge = yearCalc - yearBirth;
		}
		
		//var postPeriods = Math.ceil(postAccidentRetirementAge - (yearAcc - yearBirth));
		var postIncome = new Array();
		var postAge = new Array();
		var postYear = new Array();
		var postTax = new Array();
		var postDiscount = new Array();
		var postSurvival = new Array();
		var postCapResults = new Array();
		var postContingency = new Array();
		var postResult = 0;
		//var postAnnualIncrease = (postAccidentCeiling - accidentEarnings) / (postAccidentCeilingAge - (yearAcc - yearBirth) - 1);
		var postAnnualIncrease = (postAccidentCeiling - earningsAtCalc) / (postAccidentCeilingAge - (yearCalc - yearBirth));
		var eliminationInidicator = 1;
		

		for (i = 0; i < periods; i++){
			postAge[i] = i + yearAcc - yearBirth;
			
			postYear[i] = yearAcc + i;
			
			if(postYear[i] <= yearCalc){
				postContingency[i] = pastPostCon;
			}
			else {
				postContingency[i] = futurePostCon;
			}

			if(postAge[i] > postAccidentRetirementAge){
				eliminationInidicator = 0;
			}
			else {
				eliminationInidicator = 1;
			}

		
			if(postYear[i] <= yearCalc){
				if(preAccidentEqualiser == 1){
					postIncome[i] = income[i];
				}
				else {
					if(isNaN(parseFloat(document.getElementById("pastEarnings" + i).value))){
						alert("Please complete the post-accident earnings form.");
						return;
					}
					else {
						postIncome[i] = parseFloat(document.getElementById("pastEarnings" + i).value) /* Math.pow(inflation,yearCalc - postYear[i]) */ * eliminationInidicator;
					}
				}
			}
			else {
				if(postAge[i] > postAccidentCeilingAge){
					postIncome[i] = postIncome[i-1] * eliminationInidicator;
				}
				else {
					if(preEarningsMethod == 3){
						if(postAge[i] <= initialAgePre){
							postIncome[i] = income[i];
						}
						else{
							postIncome[i] = (initialEarningsPre + ((postAccidentCeiling - initialEarningsPre) / (postAccidentCeilingAge - initialAgePre)) * (i - (initialAgePre - yearAcc + yearBirth))) * eliminationInidicator;
						}
					}
					else {
						postIncome[i] = (earningsAtCalc + postAnnualIncrease * (i - (yearCalc - yearAcc))) * eliminationInidicator;
					}
				}
			}
							
			
			postTax[i] = taxCalc(postIncome[i]) * eliminationInidicator;
			
			if(postYear[i] < yearCalc){
				postSurvival[i] = 1;
				postDiscount[i] = 1 / (Math.pow(inflation,yearCalc-postYear[i]));
			}            
			else {
				postDiscount[i] = 1 / (Math.pow(discountRate,postYear[i]-yearCalc+2));
				
				if(yearAcc == yearCalc && i == 0){
					postSurvival[i] = lifeTable[ages.indexOf(age[i])];
				}
				else {
					postSurvival[i] = survival[i-1] * lifeTable[ages.indexOf(age[i])];
				}
				
			}
			
			if(postYear[i] == yearAcc){
				periodMultiplier = accidentPeriod;
			}
			else if(periods - i == 1){
				periodMultiplier = 0.5;
			}
			else{
				periodMultiplier = 1;
			}

			postResult += (postIncome[i] - postTax[i]) * postDiscount[i] * postSurvival[i] * periodMultiplier;
			postCapResults[i] = (postIncome[i] - postTax[i]) * postDiscount[i] * postSurvival[i] * periodMultiplier;
			console.log("HRT Year " + postYear[i] + " indicator = " + preAccidentEqualiser + " R" + postIncome[i] + " multiplier = " + periodMultiplier + " discount = " + postDiscount[i] + " tax = R " + postTax[i] + " NPV = " + ((postIncome[i] - postTax[i]) * postDiscount[i] * postSurvival[i] * periodMultiplier));
			
		}

		//document.getElementById("postResult").innerHTML = "Post-Accident =  R " + postResult.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
		

		/*---------------------------------------------------------------------------------------------------------------*/
		// END POST-ACCIDENT
		/*---------------------------------------------------------------------------------------------------------------*/
		
		/*---------------------------------------------------------------------------------------------------------------*/
		// START Cap Calculation & Deduction
		/*---------------------------------------------------------------------------------------------------------------*/
		var contingencyDeduction = 0;
		var preResultsPostContingency = 0;
		var postResultsPostContingency = 0;
		var capResult = 0;
		
		for(i = 0; i < periods; i++){
			if(((preCapResults[i] * (1 - contingency[i])) - (postCapResults[i] * (1 - postContingency[i]))) > cap ){
				contingencyDeduction += (preCapResults[i] * (1 - contingency[i])) - (postCapResults[i] * (1 - postContingency[i])) - cap;
			}
			else {
				contingencyDeduction += 0;
			}
			preResultsPostContingency += preCapResults[i] * (1 - contingency[i]);
			postResultsPostContingency += postCapResults[i] * (1 - postContingency[i]);
			capResult += (preCapResults[i] * (1 - contingency[i])) - (postCapResults[i] * (1 - postContingency[i]));
			//console.log(i + "    " + contingency[i] + "    " + postContingency[i] + "    " + contingencyDeduction);
			//console.log(preCapResults[i] + " .. " + contingency[i] + " .. " + postCapResults[i] + " .. " + postContingency[i] + " .. " + cap + " .... " );
		}
		
		capResult = capResult - contingencyDeduction;

		//document.getElementById("totalResult").innerHTML = "Total Loss =  R " + (result - postResult).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
		//document.getElementById("preResultCon").innerHTML = "Pre-Accident Post Contingency =  R " + preResultsPostContingency.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
		//document.getElementById("postResultCon").innerHTML = "Post-Accident Post Contingency =  R " + postResultsPostContingency.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
		//document.getElementById("totalResultCon").innerHTML = "Total Loss =  R " + capResult.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
		
		document.getElementById("preResult").innerHTML = "<b>Pre-Accident =  R " + preResultsPostContingency.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + '</b>';
		document.getElementById("postResult").innerHTML = "<b>Post-Accident =  R " + postResultsPostContingency.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + '</b>';
		document.getElementById("totalResult").innerHTML = "<b>Total Loss =  R " + capResult.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + '</b>';
		
		document.getElementById("resultsSection").style.height = "650px";
		//document.getElementById("totalResultCon").innerHTML = "Total Loss = R" + ((1 - futurePreCon) * result - (1 - futurePostCon) * postResult);
		/*---------------------------------------------------------------------------------------------------------------*/
		// END Cap Calculation & Deduction
		/*---------------------------------------------------------------------------------------------------------------*/
			
		
		
    }

/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/


	function printResults(){
		var months = ["January"," February","March","April","May","June","July","August","September","October","November","December"];
		var dateBirth1 = new Date(document.getElementById("dateBirth").value);
		var dateAcc1 = new Date(document.getElementById("dateAccident").value);
		var dateCalc1 = new Date(document.getElementById("dateCalculation").value);
		var htmlBegText = "<!DOCTYPE html><html lang=\"en\">";
		var htmlEndText = "</html>";
		var bodyBegText = "<body>";
		var bodyEndText = "</body>";
		var headerText = "<head><meta charset=\"utf-8\"><meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"><meta name=\"viewport\" content=\"width=device-width, initial-scale=1\"><title>Exchange Capital Road Accident Fund Results</title><link rel=\"stylesheet\" href=\"https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css\" integrity=\"sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS\" crossorigin=\"anonymous\"><link rel=\"stylesheet\" href=\"styles.css\" type=\"text/css\"></head>";
		var logo = "<div style=\"text-align: center\"><img src=\"excapLogo.png\" alt=\"Exchange Capital Logo\" height=\"100px\" width=\"200px\"></div>";
		var headingText = "<div style=\"text-align: center\"><u><h5>Loss of Income Estimation</h5></u></div>";
		var birthDateText = "<p>Date of Birth:<br>" + dateBirth1.getDate() + " " + months[dateBirth1.getMonth()] + " " + dateBirth1.getFullYear() + "</p>";
		var accidentDateText = "<p>Date of Accident:<br>" + dateAcc1.getDate() + " " + months[dateAcc1.getMonth()] + " " + dateAcc1.getFullYear() + "</p>";
		var calculationDateText = "<p>Date of Calculation:<br>" + dateCalc1.getDate() + " " + months[dateCalc1.getMonth()] + " " + dateCalc1.getFullYear() + "</p>";
		if(gend == 0){
			var genderText = "<p>Gender:<br>" + "Male" + "</p>";
		}
		else 
			{var genderText = "<p>Gender:<br>" + "Female" + "</p>";}
		if(capIndicator == 1){
			var capText = "<p>Cap Application:<br>" + "Cap Applied" + "</p>";
		}
		else if (capIndicator == 0){
			var capText = "<p>Cap Application:<br>" + "Cap Not Applied" + "</p>";
		}
		var divContainerBegText = "<div class=\"container-fluid\">";
		var divFormatRowBeg = "<div class=\"row\">";
		var divFormatColBeg = "<div class=\"col-md-6\" style=\"text-align: center\">";
		var divFormatEnd = "</div>";
		var postAccidentDescriptionText = "<p></p><br>";
		var preAccidentStandardDescription = "The claimant's pre-accident career ceiling would have been R " + preAccidentCeilingGlobal + ". It is expected that the claimant would have retired at the age of " + preAccidentRetirementAgeGlobal + ".";
		
		if (preEarningsMethod == 1){
			var preAccidentDescriptionText = "The claimant was employed at the time of the accident and received an annual income of R " + accidentEarningsGlobal + ". " + preAccidentStandardDescription;
		}
		else if(preEarningsMethod == 2){
			var preAccidentDescriptionText = "The claimant was employed at the time of the accident and received an annual income of R " + accidentEarningsGlobal + ". " + preAccidentStandardDescription ;
		}
		else if(preEarningsMethod == 3){
			var preAccidentDescriptionText = "The claimant was unemployed at the time of the accident and would have entered the labour market at the age of " + initialAgePreGlobal + ". Upon entering the workplace the claimant would have received an annual income of R " + accidentEarningsGlobal + ". " + preAccidentStandardDescription;
		}
		
		
		var disclaimerText = "<p><em><b>Disclaimer</b><br>This result does not constitute and hence should not be used in place of a thorough Actuarial analysis of the true claim value. This result represents an estimation of the loss of income which is based on a number of assumptions that may not hold true to the specific case in question.</em></p>";
		var printableHtml = htmlBegText + headerText + bodyBegText + logo + "<br><br>" + headingText + "<br><br><br>" + divContainerBegText + divFormatRowBeg + divFormatColBeg + birthDateText + accidentDateText + calculationDateText + divFormatEnd + divFormatColBeg + genderText + capText + divFormatEnd + divFormatEnd + divFormatEnd + "<br><br><br>"  + divContainerBegText + divFormatRowBeg + divFormatColBeg + "<p><b>Pre-Accident Basis:</b> " + preAccidentDescriptionText + "</p><br>" + divFormatEnd + divFormatEnd + divFormatEnd + "<br><br>" + divContainerBegText + divFormatRowBeg + "<div class=\"col-md-4\"></div>" + "<div class=\"col-md-4\" style=\"text-align: center\">" + document.getElementById("preResult").innerHTML + "<br><br>" + document.getElementById("postResult").innerHTML + "<br><br>" + document.getElementById("totalResult").innerHTML + "</div>" + "<div class=\"col-md-4\"></div>" + divFormatEnd + divFormatEnd + "<br><br><br><br>" + disclaimerText + bodyEndText + htmlEndText;

		//var printableHtml = "<p>Hello</p>" + "<br>" + Date(document.getElementById("dateAccident").value) + "<br><br>" + document.getElementById("preResult").innerHTML + "<br><br>" + document.getElementById("postResult").innerHTML + "<br><br>" + document.getElementById("totalResult").innerHTML;
		w = window.open();
		w.document.write(printableHtml);
		w.print();
		w.close;
	
	}


/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/
/*---------------------------------------------------------------------------------------------------------------*/



    function clearAll(num){
	
		if (num == 1){
			if(unemployableVar == 0){
				unemployable();
			}
			document.getElementById("generalAssumptionsForm").reset();
			document.getElementById("generalDetailsForm").reset();
			document.getElementById("preAccidentForm").reset();
			document.getElementById("postAccidentForm").reset();
			document.getElementById("contingencies").reset();
			document.getElementById("postEarningsCeilingPaterson").innerHTML = "<button type=\"button\" class=\"btn btn-info\" style=\"width: 100%\" title=\"Use this option if you would like to get Paterson values\" onclick=\"paterson('postEarningsCeilingPaterson')\">Paterson</button>";
			//document.getElementById("preEarningsAccidentPaterson").innerHTML = "<button type=\"button\" class=\"btn btn-info\" style=\"width: 100%\" title=\"Use this option if you would like to get Paterson values\" onclick=\"paterson('preEarningsAccidentPaterson')\">Paterson</button>";
			document.getElementById("preEarningsAccidentDiv").innerHTML = "<button type=\"button\" class=\"btn btn-info\" style=\"width: 100%\" title=\"Use this option for uniform increases in income between the accident and the ceiling\" onclick=\"earningsType('simpleUniform')\">Employed @ Accident</button><button type=\"button\" class=\"btn btn-info\" style=\"width: 100%\" title=\"Use this option for yearly input of income between the accident date and calculation date\" onclick=\"earningsType('detailedYearly')\">Detailed Yearly</button><button type=\"button\" class=\"btn btn-info\" style=\"width: 100%\" title=\"Use this option for if the claimant was unemployed at the time of the accident\" onclick=\"earningsType('unemployed')\">Unemployed @ Accident</button>";
			document.getElementById("preEarningsCeilingPaterson").innerHTML = "<button type=\"button\" class=\"btn btn-info\" style=\"width: 100%\" title=\"Use this option if you would like to get Paterson values\" onclick=\"paterson('preEarningsCeilingPaterson')\">Paterson</button>";
			//document.getElementById("postAccidentActuals").innerHTML = postPastEarningsEmptyState;
			postEarningsSetup('post');
			//document.getElementById("earningsStartPre").innerHTML = "";
			document.getElementById("earningsStartPost").innerHTML = "";
			preAccidentEqualiser = 0;
			gend = 0;
			document.getElementById("maleButton").innerHTML = "<button class=\"btn btn-light\" onclick=\"setGender(0)\">Male</button>";
			document.getElementById("femaleButton").innerHTML = "<button class=\"btn btn-light\" onclick=\"setGender(1)\">Female</button>";
			capIndicator = 1;
			document.getElementById("capButton").innerHTML = "<button class=\"btn btn-light\" onclick=\"setCap(1)\">Cap</button>";
			document.getElementById("noCapButton").innerHTML = "<button class=\"btn btn-light\" onclick=\"setCap(0)\">No Cap</button>";
			document.getElementById("preAccidentForm").style.marginLeft = "25%";
			document.getElementById("preAccidentForm").style.marginRight = "25%";
			document.getElementById("earningsAccidentWording").innerHTML = "Earnings @ Accident";

		}
		else if (num == 2) {
			if(unemployableVar == 0){
				unemployable();
			}
			document.getElementById("postAccidentForm").reset();
			document.getElementById("postEarningsCeilingPaterson").innerHTML = "<button type=\"button\" class=\"btn btn-info\" style=\"width: 100%\" title=\"Use this option if you would like to get Paterson values\" onclick=\"paterson('postEarningsCeilingPaterson')\">Paterson</button>";
			//document.getElementById("postAccidentActuals").innerHTML = postPastEarningsEmptyState;
			postEarningsSetup('post');
			document.getElementById("earningsStartPost").innerHTML = "";
			preAccidentEqualiser = 0;
		}
		else if (num == 3) {
			document.getElementById("preAccidentForm").reset();
			//document.getElementById("preEarningsAccidentPaterson").innerHTML = "<button type=\"button\" class=\"btn btn-info\" style=\"width: 100%\" title=\"Use this option if you would like to get Paterson values\" onclick=\"paterson('preEarningsAccidentPaterson')\">Paterson</button>";
			document.getElementById("preEarningsCeilingPaterson").innerHTML = "<button type=\"button\" class=\"btn btn-info\" style=\"width: 100%\" title=\"Use this option if you would like to get Paterson values\" onclick=\"paterson('preEarningsCeilingPaterson')\">Paterson</button>";
			//document.getElementById("earningsStartPre").innerHTML = "";
			document.getElementById("preEarningsAccidentDiv").innerHTML = "<button type=\"button\" class=\"btn btn-info\" style=\"width: 100%\" title=\"Use this option for uniform increases in income between the accident and the ceiling\" onclick=\"earningsType('simpleUniform')\">Employed @ Accident</button><button type=\"button\" class=\"btn btn-info\" style=\"width: 100%\" title=\"Use this option for yearly input of income between the accident date and calculation date\" onclick=\"earningsType('detailedYearly')\">Detailed Yearly</button><button type=\"button\" class=\"btn btn-info\" style=\"width: 100%\" title=\"Use this option for if the claimant was unemployed at the time of the accident\" onclick=\"earningsType('unemployed')\">Unemployed @ Accident</button>";
			document.getElementById("preAccidentForm").style.marginLeft = "25%";
			document.getElementById("preAccidentForm").style.marginRight = "25%";
			document.getElementById("earningsAccidentWording").innerHTML = "Earnings @ Accident";

		}
       
    }


</script>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>


</html>
