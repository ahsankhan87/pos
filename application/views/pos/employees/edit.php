<?php
if($this->session->flashdata('message'))
{
    echo "<div class='alert alert-danger fade in'>";
    echo $this->session->flashdata('message');
    echo '</div>';
}
?>

<?php 
foreach($employee as $values):
$attributes = array('class' => 'form-horizontal', 'role' => 'form', 'enctype'=>"multipart/form-data");
echo validation_errors();
echo form_open('pos/C_employees/edit',$attributes);

echo form_hidden('id',$values['id']);

echo '<div class="form-group"><label class="control-label col-sm-2" for="Account">Cash Account</label>';
echo '<div class="col-sm-10">';
echo form_dropdown('cash_acc_code',$accountDDL,$values['cash_acc_code'],'class="form-control select2me"');
echo '</div></div>';
?>
<div class="form-group">
  <label class="control-label col-sm-2" for="salary_acc_code">Salary Account:</label>
  <div class="col-sm-10">
    <?php echo form_dropdown('salary_acc_code',$accountDDL,$values['salary_acc_code'],'class="form-control select2me"'); ?>
  </div>
</div>
<!--
<div class="form-group">
  <label class="control-label col-sm-2" for=" ">Username:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="username" name="username" value="<?php echo $values['username']; ?>" placeholder="username"/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for=" ">Password:</label>
  <div class="col-sm-10">
    <input type="password" class="form-control" id="password" name="password" value="<?php echo $values['password']; ?>" placeholder="password"/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for=" ">Confrim Password:</label>
  <div class="col-sm-10">
    <input type="password" class="form-control" id="confrim_password" name="confrim_password" placeholder="Confrim Password"/>
  </div>
</div>
-->
<div class="form-group">
  <label class="control-label col-sm-2" for="employee Name">Employee First Name:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $values['first_name']; ?>" placeholder="Employee First Name"/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="employee Name">Employee Last Name:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $values['last_name']; ?>" placeholder="Employee Last Name"/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="father_name">Father Name:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="father_name" name="father_name" value="<?php echo $values['father_name']; ?>" placeholder="Employee First Name"/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="employee Name">CNIC:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="cnic" name="cnic" value="<?php echo $values['cnic']; ?>" placeholder="CNIC"/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="Email">Email:</label>
  <div class="col-sm-10">
    <input type="email" class="form-control" id="Email" name="email" value="<?php echo $values['email']; ?>" placeholder="employee Email"/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for=" ">City:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="" name="city" value="<?php echo $values['city']; ?>" />
  </div>
</div>
<?php 
 
 echo '<div class="form-group"><label class="control-label col-sm-2" for="">Country</label>';
 echo '<div class="col-sm-10">';
 $country = array( "" => "Select Country","Afghanistan" => "Afghanistan" , "Albania" => "Albania" , "Algeria" => "Algeria" , "American Samoa" => "American Samoa" , "Andorra" => "Andorra" , "Angola" => "Angola" , "Anguilla" => "Anguilla" , "Antarctica" => "Antarctica" , "Antigua and Barbuda" => "Antigua and Barbuda" , "Argentina" => "Argentina" , "Armenia" => " Armenia " , " Aruba " => " Aruba " , " Australia " => " Australia " , " Austria " => " Austria " , " Azerbaijan " => " Azerbaijan " , " Bahamas " => " Bahamas " , " Bahrain " => " Bahrain " , " Bangladesh " => " Bangladesh " , " Barbados " => " Barbados " , " Belarus " => " Belarus " , " Belgium " => " Belgium " , " Belize " => " Belize " , " Benin " => " Benin " , " Bermuda " => " Bermuda " , " Bhutan " => " Bhutan " , " Bolivia " => " Bolivia " , " Bosnia and Herzegovina " => " Bosnia and Herzegovina " , " Botswana " => " Botswana " , " Bouvet Island " => " Bouvet Island " , " Brazil " => " Brazil " , " British Antarctic Territory " => " British Antarctic Territory " , " British Indian Ocean Territory " => " British Indian Ocean Territory " , " British Virgin Islands " => " British Virgin Islands " , " Brunei " => " Brunei " , " Bulgaria " => " Bulgaria " , " Burkina Faso " => " Burkina Faso " , " Burundi " => " Burundi " , " Cambodia " => " Cambodia " , " Cameroon " => " Cameroon " , " Canada " => " Canada " , " Canton and Enderbury Islands " => " Canton and Enderbury Islands " , " Cape Verde " => " Cape Verde " , " Cayman Islands " => " Cayman Islands " , " Central African Republic " => " Central African Republic " , " Chad " => " Chad " , " Chile " => " Chile " , " China " => " China " , " Christmas Island " => " Christmas Island " , " Cocos [Keeling] Islands " => " Cocos [Keeling] Islands " , " Colombia " => " Colombia " , " Comoros " => " Comoros " , " Congo - Brazzaville " => " Congo - Brazzaville " , " Congo - Kinshasa " => " Congo - Kinshasa " , " Cook Islands " => " Cook Islands " , " Costa Rica " => " Costa Rica " , " Croatia " => " Croatia " , " Cuba " => " Cuba " , " Cyprus " => " Cyprus " , " Czech Republic " => " Czech Republic " , " Côte d’Ivoire " => " Côte d’Ivoire " , " Denmark " => " Denmark " , " Djibouti " => " Djibouti " , " Dominica " => " Dominica " , " Dominican Republic " => " Dominican Republic " , " Dronning Maud Land " => " Dronning Maud Land " , " East Germany " => " East Germany " , " Ecuador " => " Ecuador " , " Egypt " => " Egypt " , " El Salvador " => " El Salvador " , " Equatorial Guinea " => " Equatorial Guinea " , " Eritrea " => " Eritrea " , " Estonia " => " Estonia " , " Ethiopia " => " Ethiopia " , " Falkland Islands " => " Falkland Islands " , " Faroe Islands " => " Faroe Islands " , " Fiji " => " Fiji " , " Finland " => " Finland " , " France " => " France " , " French Guiana " => " French Guiana " , " French Polynesia " => " French Polynesia " , " French Southern Territories " => " French Southern Territories " , " French Southern and Antarctic Territories " => " French Southern and Antarctic Territories " , " Gabon " => " Gabon " , " Gambia " => " Gambia " , " Georgia " => " Georgia " , " Germany " => " Germany " , " Ghana " => " Ghana " , " Gibraltar " => " Gibraltar " , " Greece " => " Greece " , " Greenland " => " Greenland " , " Grenada " => " Grenada " , " Guadeloupe " => " Guadeloupe " , " Guam " => " Guam " , " Guatemala " => " Guatemala " , " Guernsey " => " Guernsey " , " Guinea " => " Guinea " , " Guinea-Bissau " => " Guinea-Bissau " , " Guyana " => " Guyana " , " Haiti " => " Haiti " , " Heard Island and McDonald Islands " => " Heard Island and McDonald Islands " , " Honduras " => " Honduras " , " Hong Kong SAR China " => " Hong Kong SAR China " , " Hungary " => " Hungary " , " Iceland " => " Iceland " , "India" => "India" , " Indonesia " => " Indonesia " , " Iran " => " Iran " , " Iraq " => " Iraq " , " Ireland " => " Ireland " , " Isle of Man " => " Isle of Man " , " Israel " => " Israel " , " Italy " => " Italy " , " Jamaica " => " Jamaica " , " Japan " => " Japan " , " Jersey " => " Jersey " , " Johnston Island " => " Johnston Island " , " Jordan " => " Jordan " , " Kazakhstan " => " Kazakhstan " , " Kenya " => " Kenya " , " Kiribati " => " Kiribati " , " Kuwait " => " Kuwait " , " Kyrgyzstan " => " Kyrgyzstan " , " Laos " => " Laos " , " Latvia " => " Latvia " , " Lebanon " => " Lebanon " , " Lesotho " => " Lesotho " , " Liberia " => " Liberia " , " Libya " => " Libya " , " Liechtenstein " => " Liechtenstein " , " Lithuania " => " Lithuania " , " Luxembourg " => " Luxembourg " , " Macau SAR China " => " Macau SAR China " , " Macedonia " => " Macedonia " , " Madagascar " => " Madagascar " , " Malawi " => " Malawi " , " Malaysia " => " Malaysia " , " Maldives " => " Maldives " , " Mali " => " Mali " , " Malta " => " Malta " , " Marshall Islands " => " Marshall Islands " , " Martinique " => " Martinique " , " Mauritania " => " Mauritania " , " Mauritius " => " Mauritius " , " Mayotte " => " Mayotte " , " Metropolitan France " => " Metropolitan France " , " Mexico " => " Mexico " , " Micronesia " => " Micronesia " , " Midway Islands " => " Midway Islands " , " Moldova " => " Moldova " , " Monaco " => " Monaco " , " Mongolia " => " Mongolia " , " Montenegro " => " Montenegro " , " Montserrat " => " Montserrat " , " Morocco " => " Morocco " , " Mozambique " => " Mozambique " , " Myanmar [Burma] " => " Myanmar [Burma] " , " Namibia " => " Namibia " , " Nauru " => " Nauru " , " Nepal " => " Nepal " , " Netherlands " => " Netherlands " , " Netherlands Antilles " => " Netherlands Antilles " , " Neutral Zone " => " Neutral Zone " , " New Caledonia " => " New Caledonia " , " New Zealand " => " New Zealand " , " Nicaragua " => " Nicaragua " , " Niger " => " Niger " , " Nigeria " => " Nigeria " , " Niue " => " Niue " , " Norfolk Island " => " Norfolk Island " , " North Korea " => " North Korea " , " North Vietnam " => " North Vietnam " , " Northern Mariana Islands " => " Northern Mariana Islands " , " Norway " => " Norway " , " Oman " => " Oman " , " Pacific Islands Trust Territory " => " Pacific Islands Trust Territory " , " Pakistan " => " Pakistan " , " Palau " => " Palau " , " Palestinian Territories " => " Palestinian Territories " , " Panama " => " Panama " , " Panama Canal Zone " => " Panama Canal Zone " , " Papua New Guinea " => " Papua New Guinea " , " Paraguay " => " Paraguay " , " People's Democratic Republic of Yemen " => " People's Democratic Republic of Yemen " , " Peru " => " Peru " , " Philippines " => " Philippines " , " Pitcairn Islands " => " Pitcairn Islands " , " Poland " => " Poland " , " Portugal " => " Portugal " , " Puerto Rico " => " Puerto Rico " , " Qatar " => " Qatar " , " Romania " => " Romania " , " Russia " => " Russia " , " Rwanda " => " Rwanda " , " Réunion " => " Réunion " , " Saint Barthélemy " => " Saint Barthélemy " , " Saint Helena " => " Saint Helena " , " Saint Kitts and Nevis " => " Saint Kitts and Nevis " , " Saint Lucia " => " Saint Lucia " , " Saint Martin " => " Saint Martin " , "Saint Pierre and Miquelon" => "Saint Pierre and Miquelon" , "Saint Vincent and the Grenadines" => "Saint Vincent and the Grenadines" , "Samoa" => "Samoa" , "San Marino" => "San Marino" , "Saudi Arabia" => "Saudi Arabia" , "Senegal" => "Senegal" , "Serbia" => "Serbia" , "Serbia and Montenegro" => "Serbia and Montenegro" , "Seychelles" => "Seychelles" , "Sierra Leone" => "Sierra Leone" , "Singapore" => "Singapore" , "Slovakia" => "Slovakia" , "Slovenia" => "Slovenia" , "Solomon Islands" => "Solomon Islands" , "Somalia" => "Somalia" , "South Africa" => "South Africa" , "South Georgia and the South Sandwich Islands" => "South Georgia and the South Sandwich Islands" , "South Korea" => "South Korea" , "Spain" => "Spain" , "Sri Lanka" => "Sri Lanka" , "Sudan" => "Sudan" , "Suriname" => "Suriname" , "Svalbard and Jan Mayen" => "Svalbard and Jan Mayen" , "Swaziland" => "Swaziland" , "Sweden" => "Sweden" , "Switzerland" => "Switzerland" , "Syria" => "Syria" , "São Tomé and Príncipe" => "São Tomé and Príncipe" , "Taiwan" => "Taiwan" , "Tajikistan" => "Tajikistan" , "Tanzania" => "Tanzania" , "Thailand" => "Thailand" , "Timor-Leste" => "Timor-Leste" , "Togo" => "Togo" , "Tokelau" => "Tokelau" , "Tonga" => "Tonga" , "Trinidad and Tobago" => "Trinidad and Tobago" , "Tunisia" => "Tunisia" , "Turkey" => "Turkey" , "Turkmenistan" => "Turkmenistan" , "Turks and Caicos Islands" => "Turks and Caicos Islands" , "Tuvalu" => "Tuvalu" , "U.S. Minor Outlying Islands" => "U.S. Minor Outlying Islands" , "U.S. Miscellaneous Pacific Islands" => "U.S. Miscellaneous Pacific Islands" , "U.S. Virgin Islands" => "U.S. Virgin " , "Uganda" => "Uganda" , "Ukraine" => "Ukraine" , "Union of Soviet Socialist Republics" => "Union of Soviet Socialist Republics" , "United Arab Emirates" => "United Arab Emirates" , "United Kingdom" => "United Kingdom" , "United States" => "United States" , "Unknown or Invalid Region" => "Unknown or Invalid Region" , "Uruguay" => "Uruguay" , "Uzbekistan" => "Uzbekistan" , "Vanuatu" => "Vanuatu" , "Vatican City" => "Vatican City" , "Venezuela" => "Venezuela" , "Vietnam" => "Vietnam" , "Wake Island" => "Wake Island" , "Wallis and Futuna" => "Wallis and Futuna" , "Western Sahara" => "Western Sahara" , "Yemen" => "Yemen" , "Zambia" => "Zambia" , "Zimbabwe" => "Zimbabwe" , "Åland Islands" => "Åland Islands");
 echo form_dropdown('country',$country,$values['country'],'class="form-control select2me"') . '</div></div>';
  ?>
 
<div class="form-group">
  <label class="control-label col-sm-2" for="Contactno">Contact No:</label>
  <div class="col-sm-10">
    <input type="number" class="form-control" id="" name="contact" value="<?php echo $values['contact']; ?>" placeholder="Contact No"/>
  </div>
</div>

<?php 
echo '<div class="form-group"><label class="control-label col-sm-2" for="">Job Type</label>';
echo '<div class="col-sm-10">';
$option = array('0'=>'Please Select','Manager'=>'Manager','Assistant'=>'Assistant','Sales Man'=>'Sales Man','Others'=>'Others');
echo form_dropdown('job_type',$option,$values['job_type'],'class="form-control"') . '</div></div>';
?>

<div class="form-group">
  <label class="control-label col-sm-2" for="Address">Address:</label>
  <div class="col-sm-10">
    <textarea name="address" class="form-control"><?php echo $values['address']; ?></textarea>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="hire_date">Hire Date:</label>
  <div class="col-sm-10">
    <input type="date" class="form-control" id="" name="hire_date" value="<?php echo $values['hire_date']; ?>" placeholder="Hire Date"/>
  </div>
</div>
<!--
<div class="form-group">
  <label class="control-label col-sm-2" for="area_id">Select Area:</label>
  <div class="col-sm-10">
    <?php echo form_dropdown('area_id',$areaDDL,$values['area_id'],'class="form-control select2me"'); ?>
  </div>
</div>
-->
<?php 
 
echo '<div class="form-group"><label class="control-label col-sm-2" for="submit"></label>';
echo '<div class="col-sm-10">';
echo form_submit('submit','Update','class="btn"');
echo '</div></div>';
endforeach;
?>
 

