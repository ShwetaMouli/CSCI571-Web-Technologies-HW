
<html>
<head>
	<title>Real Estate Search</title> 
	<script type="text/javascript">
	function ValidateForm(){
		form = document.forms["ZillowForm"];
		var streetAddress=form.StreetAddress.value;
		var city=form.City.value;
		var state=form.State.value;
		var errorString="Please enter the value for ";
		if (!streetAddress) { errorString += "Street Address "};
		if (!city) {errorString += "City "};
		if (state=='' && (!streetAddress || !city)) {errorString += 

"and State "}
		else if (state==''){errorString += "State"};
		if (!streetAddress || !city || state=='') { alert

(errorString); return false; };
	}
	</script>
</head>

<body>
	<h2 style="text-align: center">Real Estate Search</h2>
	<div style="position: relative; margin-left:auto; margin-right:auto; 

border:2px solid black; width: 450px; height: 220px; padding-left: 10px;">
	<form id="ZillowForm" name="ZillowForm" action="<?php echo 

htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return ValidateForm();" 

method="post">
	<table style="margin-right:auto;">
	<tr><td>Street Adress*:</td> <td><input type="text" 

name="StreetAddress" /></td><td/></tr>
	
	<tr><td>City*: </td><td><input type="text" name="City" 

/></td><td/></tr>
	<tr><td>
	State*:</td><td>
			<select name="State">
			<option selected="true"></option>
			<option value="AL">AL</option>
			<option value="AK">AK</option>
			<option value="AZ">AZ</option>
			<option value="AR">AR</option>
			<option value="CA">CA</option>
			<option value="CO">CO</option>
			<option value="CT">CT</option>
			<option value="DE">DE</option>
			<option value="DC">DC</option>
			<option value="FL">FL</option>
			<option value="GA">GA</option>
			<option value="HI">HI</option>
			<option value="ID">ID</option>
			<option value="IL">IL</option>
			<option value="IN">IN</option>
			<option value="IA">IA</option>
			<option value="KS">KS</option>
			<option value="KY">KY</option>
			<option value="LA">LA</option>
			<option value="ME">ME</option>
			<option value="MD">MD</option>
			<option value="MA">MA</option> 
			<option value="MI">MI</option>
			<option value="MN">MN</option>
			<option value="MS">MS</option>
			<option value="MO">MO</option>
			<option value="MT">MT</option>
			<option value="NE">NE</option>
			<option value="NV">NV</option>
			<option value="NH">NH</option> 
			<option value="NJ">NJ</option>
			<option value="NM">NM</option>
			<option value="NY">NY</option>
			<option value="NC">NC</option>
			<option value="ND">ND</option>
			<option value="OH">OH</option>
			<option value="OK">OK</option>
			<option value="OR">OR</option>
			<option value="PA">PA</option> 
			<option value="RI">RI</option>
			<option value="SC">SC</option>
			<option value="SD">SD</option>
			<option value="TN">TN</option>
			<option value="TX">TX</option>
			<option value="UT">UT</option>
			<option value="VT">VT</option>
			<option value="VA">VA</option>
			<option value="WA">WA</option>
			<option value="WV">WV</option>
			<option value="WI">WI</option>
			<option value="WY">WY</option>
			</select></td><td/></tr>

		
		<tr><td></td><td><input type="submit" name="Search" 

value="Search"></td><td/></tr>
		<br/>

		<tr><td/><td/><td><img 

src="http://www.zillow.com/widgets/GetVersionedResource.htm?

path=/static/logos/Zillowlogo_150x40.gif" width="150" height="40" alt="Zillow 

Real Estate Search" /></td></tr>

	</table>
	
	</form>
	
	<p> * - <i> Mandatory fields. </i> </p>
	</div>
		
</html>

<?php
	error_reporting(E_ERROR | E_PARSE);
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
    	$zwsid = "X1-ZWz1dxk6c7yhor_7c2wf";
    	$state = $_POST["State"];
    	$address = str_replace(' ', '+', $_POST["StreetAddress"]);
    	$address = strtolower($address);
    	$city = str_replace(' ', '+', $_POST["City"]);
    	//$city = strtolower($city);

    	$zillowURL = 

"http://www.zillow.com/webservice/GetDeepSearchResults.htm?zws-id=".

$zwsid."&address=".$address."&citystatezip=".$city."%2C+".

$state."&rentzestimate=true";

    	$headers = get_headers($zillowURL);
    	$errors = substr($headers[0], 9, 3);
    	//echo print_r($headers);
		if($errors != "404")
		{
			$xmlStr = file_get_contents($zillowURL);
			$xmlData = simplexml_load_string($xmlStr);
			if($xmlData->message->code == 0)
			{
				$hyperlink =  (string)$xmlData->response-

>results->result->links->homedetails;
				$data = $xmlData->response->results->result;
				//echo '<pre>'; print_r($xmlData); echo 

'</pre>';
				//$hl = simplexml_load_string($hyperlink);
				//$h1 = $hyperlink;
				$zpid = (string)$data->zpid;
				$propertyType = (string)$data->useCode;
				$yearBuilt = (string)$data->yearBuilt;
				$lotSize = (string)$data->lotSizeSqFt;
				$finishedArea = (string)$data->finishedSqFt;
				$bathrooms = (string)$data->bathrooms;
				$bedrooms = (string)$data->bedrooms;
				$taxAssessmentYear = (string)$data-

>taxAssessmentYear;
				$taxAssessment = (string)$data->taxAssessment;
				$lastSoldPrice = (double)$data->lastSoldPrice;
				$lastSoldDate = (string)$data->lastSoldDate;
				$lastUpdated = (string)$data->zestimate-

>lastUpdated;
				$LUdate = date_create($lastUpdated, 

timezone_open('Pacific/Nauru'));
				$LUprintDate = (string)date_format($LUdate, 

'd-M-Y');
				$date = date_create($lastSoldDate, 

timezone_open('Pacific/Nauru'));
				$printDate = (string)date_format($date, 'd-M-

Y');
				$zestimate = (string)$data->zestimate->amount;
				$thirtyDay = (double)$data->zestimate-

>valueChange;
				$allTimeRange = (string)number_format

((double)$data->zestimate->valuationRange->low, 2) ." - $". 

(string)number_format((double)$data->zestimate->valuationRange->high, 2);
				$rentzestimate = (string)$data-

>rentzestimate->amount;
				$thirtyDayRent = (string)$data-

>rentzestimate->valueChange;
				$rentzestValuationDate = (string)$data-

>rentzestimate->{'last-updated'};
				$RZdate = date_create($rentzestValuationDate, 

timezone_open('Pacific/Nauru'));
				$RZprintDate = (string)date_format($RZdate, 

'd-M-Y');
				$allTimeRentRange = (string)number_format

((double)$data->rentzestimate->valuationRange->low, 2) ." - $". 

(string)number_format((double)$data->rentzestimate->valuationRange->high, 2);
				

				$rentRange = (string)$data->rentzestimate-

>valuationRange->low .'-'. $data->rentzestimate->valuationRange->high;
				echo "<br>
				<div style = \"width:100%; background-color: 

#F1EAC2; border-style: solid; border-radius: 3px; border-width:thin; height: 

20px\">
					See more details for "."<a href=\"".

$hyperlink."\" style=\"text-decoration: none; font-weight: bold;\">".

(string)$data->address->street.", ".(string)$data->address->city.", ".

(string)$data->address->state."-".(string)$data->address->zipcode."</a> on 

Zillow."."</div>"; 
				echo "<table style=\"width:100%\">
						<tr><td style=\"width:25%

\">Property Type</td><td style=\"width:25%;\">".$propertyType."</td><td 

style=\"width:25%;\">Last Sold Price</td><td style=\"text-align:right; 

width:25%;\">$".(string)number_format($lastSoldPrice, 2)."</td></tr>";
				echo "<tr><td style=\"width:25%\">Year 

Built</td><td style=\"width:25%;\">".$yearBuilt."</td><td style=\"width:25%;

\">Last Sold Date</td><td style=\"text-align:right; width:25%;\">".

$printDate."</td></tr>";
				echo "<tr><td style=\"width:25%\">Lot 

Size</td><td style=\"width:25%;\">".$lotSize." sq. ft."."</td><td style=

\"width:25%;\">Zestimate &copy; Property Estimate as of ".$LUprintDate." 

</td><td style=\"text-align:right; width:25%;\">$".(string)number_format

($zestimate, 2)."</td></tr>";
				echo "<tr><td style=\"width:25%\">Finished 

Area</td><td style=\"width:25%;\">".$finishedArea." sq. ft."."</td><td style=

\"width:25%;\">30 Days Overall Change ";
				if($thirtyDay < 0)
				{
					echo "<img src=\"down_r.gif\"></img>";
					echo ":</td><td style=\"text-

align:right; width:25%;\">$".(string)number_format(-1*$thirtyDay, 

2)."</td></tr>";
				}
				else
				{
					echo "<img src=\"up_g.gif\"></img>";	
					echo ":</td><td style=\"text-

align:right; width:25%;\">$".(string)number_format($thirtyDay, 

2)."</td></tr>";
				}
				echo "<tr><td style=\"width:25%

\">Bathrooms</td><td style=\"width:25%;\">".(string)number_format($bathrooms, 

1)."</td><td style=\"width:25%;\">All Time Property Range</td><td style=

\"text-align:right; width:25%;\">$".$allTimeRange."</td></tr>";
				echo "<tr><td style=\"width:25%

\">Bedrooms</td><td style=\"width:25%;\">".(string)number_format

($bedrooms)."</td><td style=\"width:25%;\">Rent Zestimate &copy; Valuation as 

of ".$RZprintDate.": "."</td><td style=\"text-align:right; width:25%;\">$".

(string)number_format($rentzestimate, 2)."</td></tr>";
				echo "<tr><td style=\"width:25%\">Tax 

Assessment Year</td><td style=\"width:25%;\">".$taxAssessmentYear."</td><td 

style=\"width:25%;\">30 Days Rent Change ";
				if($thirtyDayRent < 0)
				{
					echo "<img src=\"down_r.gif\"></img>";
					echo ":</td><td style=\"text-

align:right; width:25%;\">$".(string)number_format(-1*$thirtyDayRent, 

2)."</td></tr>";
				}
				else
				{
					echo "<img src=\"up_g.gif\"></img>";	
					echo ":</td><td style=\"text-

align:right; width:25%;\">$".(string)number_format($thirtyDayRent, 

2)."</td></tr>";
				}
				echo "<tr><td style=\"width:25%\">Tax 

Assessment:</td><td style=\"width:25%;\">".(string)number_format

($taxAssessment, 2)."</td><td style=\"width:25%;\">All Time Rent 

Range:"."</td><td style=\"text-align:right; width:25%;\">$".

$allTimeRentRange."</td></tr>";
				echo "</table>";
				echo "<br>";
				echo "<div style=\"text-align: center\"><p> 

&copy; Zillow, Inc., 2006-2014. Use is subject to <a href=

\"http://www.zillow.com/corp/Terms.htm\">Terms of Use</a><br><a href = 

\"http://www.zillow.com/zestimate/\">What's a Zestimate?</a></p></center>";
				echo "</div>";
				echo "</html>";
			}
			else
			{
				echo "<p style=\"font-weight: bold; text-

align: center;\">No exact match found-- Verify that the given address is 

correct.</p></html>";
			}



						
		}
										

		

    	//echo '<pre>'; print_r($headers); echo '</pre>';
    }
