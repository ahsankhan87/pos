<?php
if($this->session->flashdata('message'))
{
    echo "<div class='alert alert-danger fade in'>";
    echo $this->session->flashdata('message');
    echo '</div>';
}
?>

<?php 
$attributes = array('class' => 'form-horizontal', 'role' => 'form','enctype'=>"multipart/form-data");
echo form_open('companies/C_newStore/create',$attributes);
?>

<div class="form-group">
  <label class="control-label col-sm-2" for="Company Name">Company Name:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="name" name="name" required="" title="Company Name" placeholder="Company Name"/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="userName">Username:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="name" name="username" required="" placeholder="User Name"/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="Password">Password:</label>
  <div class="col-sm-10">
    <input type="password" class="form-control" id="password" required="" name="password" placeholder="Password"/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="Password">Confirm Password:</label>
  <div class="col-sm-10">
    <input type="password" class="form-control" id="confirm_password" required="" name="confirm_password" placeholder="Confirm Password"/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="Email">Email:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="Email" name="email" required="" placeholder="Email"/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="Address">Address:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="" name="address" required="" placeholder="Address"/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="fy_start">Fiscal Year Start:
  <div class="small">i.e 2016-01-01</div></label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="datepicker" value="<?php echo date("Y-01-01"); ?>" name="fy_start" required="" placeholder=""/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="fy_end">Fiscal Year End: 
  <div class="small">i.e 2016-12-31</div></label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="Todatepicker" value="<?php echo date("Y-12-31"); ?>" name="fy_end" required="" placeholder=""/>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="time_zone">Time Zone:</label>
  <div class="col-sm-10">
        <select class="form-control" name="time_zone"> 
            <option value="Pacific/Midway">Midway [SST -11:00]</option> 
            <option value="Pacific/Niue">Niue [NUT -11:00]</option> 
            <option value="Pacific/Apia">Apia [WST -11:00]</option> 
            <option value="Pacific/Tahiti">Tahiti [TAHT -10:00]</option> 
            <option value="Pacific/Honolulu">Honolulu [HST -10:00]</option> 
            <option value="Pacific/Rarotonga">Rarotonga [CKT -10:00]</option> 
            <option value="Pacific/Fakaofo">Fakaofo [TKT -10:00]</option> 
            <option value="Pacific/Marquesas">Marquesas [MART -09:30]</option> 
            <option value="America/Adak">Adak [HADT -09:00]</option> 
            <option value="Pacific/Gambier">Gambier [GAMT -09:00]</option> 
            <option value="America/Anchorage">Anchorage [AKDT -08:00]</option> 
            <option value="Pacific/Pitcairn">Pitcairn [PST -08:00]</option> 
            <option value="America/Dawson_Creek">Dawson Creek [MST -07:00]</option> 
            <option value="America/Dawson">Dawson [PDT -07:00]</option> 
            <option value="America/Belize">Belize [CST -06:00]</option> 
            <option value="America/Boise">Boise [MDT -06:00]</option> 
            <option value="Pacific/Easter">Easter [EAST -06:00]</option> 
            <option value="Pacific/Galapagos">Galapagos [GALT -06:00]</option> 
            <option value="America/Resolute">Resolute [CDT -05:00]</option> 
            <option value="America/Cancun">Cancun [CDT -05:00]</option> 
            <option value="America/Guayaquil">Guayaquil [ECT -05:00]</option> 
            <option value="America/Lima">Lima [PET -05:00]</option> 
            <option value="America/Bogota">Bogota [COT -05:00]</option> 
            <option value="America/Atikokan">Atikokan [EST -05:00]</option> 
            <option value="America/Caracas">Caracas [VET -04:30]</option> 
            <option value="America/Guyana">Guyana [GYT -04:00]</option> 
            <option value="America/Campo_Grande">Campo Grande [AMT -04:00]</option> 
            <option value="America/La_Paz">La Paz [BOT -04:00]</option> 
            <option value="America/Anguilla">Anguilla [AST -04:00]</option> 
            <option value="Atlantic/Stanley">Stanley [FKT -04:00]</option> 
            <option value="America/Detroit">Detroit [EDT -04:00]</option> 
            <option value="America/Boa_Vista">Boa Vista [AMT -04:00]</option> 
            <option value="America/Santiago">Santiago [CLT -04:00]</option> 
            <option value="America/Asuncion">Asuncion [PYT -04:00]</option> 
            <option value="Antarctica/Rothera">Rothera [ROTT -03:00]</option> 
            <option value="America/Paramaribo">Paramaribo [SRT -03:00]</option> 
            <option value="America/Sao_Paulo">Sao Paulo [BRT -03:00]</option> 
            <option value="America/Argentina/Buenos_Aires">Buenos Aires [ART -03:00]</option> 
            <option value="America/Cayenne">Cayenne [GFT -03:00]</option> 
            <option value="America/Glace_Bay">Glace Bay [ADT -03:00]</option> 
            <option value="America/Argentina/San_Luis">San Luis [WARST -03:00]</option> 
            <option value="America/Araguaina">Araguaina [BRT -03:00]</option> 
            <option value="America/Montevideo">Montevideo [UYT -03:00]</option> 
            <option value="America/St_Johns">St Johns [NDT -02:30]</option> 
            <option value="America/Miquelon">Miquelon [PMDT -02:00]</option> 
            <option value="America/Noronha">Noronha [FNT -02:00]</option> 
            <option value="America/Godthab">Godthab [WGST -02:00]</option> 
            <option value="Atlantic/Cape_Verde">Cape Verde [CVT -01:00]</option> 
            <option value="Atlantic/Azores">Azores [AZOST  00:00]</option> 
            <option value="America/Scoresbysund">Scoresbysund [EGST  00:00]</option> 
            <option value="UTC">UTC [UTC  00:00]</option> 
            <option value="Africa/Abidjan">Abidjan [GMT  00:00]</option> 
            <option value="Africa/Casablanca">Casablanca [WET  00:00]</option> 
            <option value="Africa/Bangui">Bangui [WAT +01:00]</option> 
            <option value="Europe/Guernsey">Guernsey [BST +01:00]</option> 
            <option value="Europe/Dublin">Dublin [IST +01:00]</option> 
            <option value="Africa/Algiers">Algiers [CET +01:00]</option> 
            <option value="Atlantic/Canary">Canary [WEST +01:00]</option> 
            <option value="Africa/Windhoek">Windhoek [WAT +01:00]</option> 
            <option value="Africa/Johannesburg">Johannesburg [SAST +02:00]</option> 
            <option value="Africa/Blantyre">Blantyre [CAT +02:00]</option> 
            <option value="Africa/Tripoli">Tripoli [EET +02:00]</option> 
            <option value="Africa/Ceuta">Ceuta [CEST +02:00]</option> 
            <option value="Asia/Jerusalem">Jerusalem [IDT +03:00]</option> 
            <option value="Africa/Addis_Ababa">Addis Ababa [EAT +03:00]</option> 
            <option value="Africa/Cairo">Cairo [EEST +03:00]</option> 
            <option value="Antarctica/Syowa">Syowa [SYOT +03:00]</option> 
            <option value="Europe/Volgograd">Volgograd [VOLST +04:00]</option> 
            <option value="Europe/Samara">Samara [SAMST +04:00]</option> 
            <option value="Asia/Tbilisi">Tbilisi [GET +04:00]</option> 
            <option value="Europe/Moscow">Moscow [MSD +04:00]</option> 
            <option value="Asia/Dubai">Dubai [GST +04:00]</option> 
            <option value="Indian/Mauritius">Mauritius [MUT +04:00]</option> 
            <option value="Indian/Reunion">Reunion [RET +04:00]</option> 
            <option value="Indian/Mahe">Mahe [SCT +04:00]</option> 
            <option value="Asia/Tehran">Tehran [IRDT +04:30]</option> 
            <option value="Asia/Kabul">Kabul [AFT +04:30]</option> 
            <option value="Asia/Aqtau">Aqtau [AQTT +05:00]</option> 
            <option value="Asia/Ashgabat">Ashgabat [TMT +05:00]</option> 
            <option value="Asia/Oral">Oral [ORAT +05:00]</option> 
            <option value="Asia/Yerevan">Yerevan [AMST +05:00]</option> 
            <option value="Asia/Baku">Baku [AZST +05:00]</option> 
            <option value="Indian/Kerguelen">Kerguelen [TFT +05:00]</option> 
            <option value="Indian/Maldives">Maldives [MVT +05:00]</option> 
            <option value="Asia/Karachi">Karachi / Islamabad [PKT +05:00]</option> 
            <option value="Asia/Dushanbe">Dushanbe [TJT +05:00]</option> 
            <option value="Asia/Samarkand">Samarkand [UZT +05:00]</option> 
            <option value="Antarctica/Mawson">Mawson [MAWT +05:00]</option> 
            <option value="Asia/Colombo">Colombo [IST +05:30]</option> 
            <option value="Asia/Kathmandu">Kathmandu [NPT +05:45]</option> 
            <option value="Indian/Chagos">Chagos [IOT +06:00]</option> 
            <option value="Asia/Bishkek">Bishkek [KGT +06:00]</option> 
            <option value="Asia/Almaty">Almaty [ALMT +06:00]</option> 
            <option value="Antarctica/Vostok">Vostok [VOST +06:00]</option> 
            <option value="Asia/Yekaterinburg">Yekaterinburg [YEKST +06:00]</option> 
            <option value="Asia/Dhaka">Dhaka [BDT +06:00]</option> 
            <option value="Asia/Thimphu">Thimphu [BTT +06:00]</option> 
            <option value="Asia/Qyzylorda">Qyzylorda [QYZT +06:00]</option> 
            <option value="Indian/Cocos">Cocos [CCT +06:30]</option> 
            <option value="Asia/Rangoon">Rangoon [MMT +06:30]</option> 
            <option value="Asia/Jakarta">Jakarta [WIT +07:00]</option> 
            <option value="Asia/Hovd">Hovd [HOVT +07:00]</option> 
            <option value="Antarctica/Davis">Davis [DAVT +07:00]</option> 
            <option value="Asia/Bangkok">Bangkok [ICT +07:00]</option> 
            <option value="Indian/Christmas">Christmas [CXT +07:00]</option> 
            <option value="Asia/Omsk">Omsk [OMSST +07:00]</option> 
            <option value="Asia/Novokuznetsk">Novokuznetsk [NOVST +07:00]</option> 
            <option value="Asia/Choibalsan">Choibalsan [CHOT +08:00]</option> 
            <option value="Asia/Ulaanbaatar">Ulaanbaatar [ULAT +08:00]</option> 
            <option value="Asia/Brunei">Brunei [BNT +08:00]</option> 
            <option value="Antarctica/Casey">Casey [WST +08:00]</option> 
            <option value="Asia/Singapore">Singapore [SGT +08:00]</option> 
            <option value="Asia/Manila">Manila [PHT +08:00]</option> 
            <option value="Asia/Hong_Kong">Hong Kong [HKT +08:00]</option> 
            <option value="Asia/Krasnoyarsk">Krasnoyarsk [KRAST +08:00]</option> 
            <option value="Asia/Makassar">Makassar [CIT +08:00]</option> 
            <option value="Asia/Kuala_Lumpur">Kuala Lumpur [MYT +08:00]</option> 
            <option value="Australia/Eucla">Eucla [CWST +08:45]</option> 
            <option value="Pacific/Palau">Palau [PWT +09:00]</option> 
            <option value="Asia/Tokyo">Tokyo [JST +09:00]</option> 
            <option value="Asia/Dili">Dili [TLT +09:00]</option> 
            <option value="Asia/Jayapura">Jayapura [EIT +09:00]</option> 
            <option value="Asia/Pyongyang">Pyongyang [KST +09:00]</option> 
            <option value="Asia/Irkutsk">Irkutsk [IRKST +09:00]</option> 
            <option value="Australia/Adelaide">Adelaide [CST +09:30]</option> 
            <option value="Asia/Yakutsk">Yakutsk [YAKST +10:00]</option> 
            <option value="Australia/Currie">Currie [EST +10:00]</option> 
            <option value="Pacific/Port_Moresby">Port Moresby [PGT +10:00]</option> 
            <option value="Pacific/Guam">Guam [ChST +10:00]</option> 
            <option value="Pacific/Truk">Truk [TRUT +10:00]</option> 
            <option value="Antarctica/DumontDUrville">DumontDUrville [DDUT +10:00]</option> 
            <option value="Australia/Lord_Howe">Lord Howe [LHST +10:30]</option> 
            <option value="Pacific/Ponape">Ponape [PONT +11:00]</option> 
            <option value="Pacific/Kosrae">Kosrae [KOST +11:00]</option> 
            <option value="Antarctica/Macquarie">Macquarie [MIST +11:00]</option> 
            <option value="Pacific/Noumea">Noumea [NCT +11:00]</option> 
            <option value="Pacific/Efate">Efate [VUT +11:00]</option> 
            <option value="Pacific/Guadalcanal">Guadalcanal [SBT +11:00]</option> 
            <option value="Asia/Sakhalin">Sakhalin [SAKST +11:00]</option> 
            <option value="Asia/Vladivostok">Vladivostok [VLAST +11:00]</option> 
            <option value="Pacific/Norfolk">Norfolk [NFT +11:30]</option> 
            <option value="Asia/Kamchatka">Kamchatka [PETST +12:00]</option> 
            <option value="Pacific/Tarawa">Tarawa [GILT +12:00]</option> 
            <option value="Asia/Magadan">Magadan [MAGST +12:00]</option> 
            <option value="Pacific/Wallis">Wallis [WFT +12:00]</option> 
            <option value="Pacific/Kwajalein">Kwajalein [MHT +12:00]</option> 
            <option value="Pacific/Funafuti">Funafuti [TVT +12:00]</option> 
            <option value="Pacific/Nauru">Nauru [NRT +12:00]</option> 
            <option value="Asia/Anadyr">Anadyr [ANAST +12:00]</option> 
            <option value="Antarctica/McMurdo">McMurdo [NZST +12:00]</option> 
            <option value="Pacific/Wake">Wake [WAKT +12:00]</option> 
            <option value="Pacific/Fiji">Fiji [FJT +12:00]</option> 
            <option value="Pacific/Chatham">Chatham [CHAST +12:45]</option> 
            <option value="Pacific/Enderbury">Enderbury [PHOT +13:00]</option> 
            <option value="Pacific/Tongatapu">Tongatapu [TOT +13:00]</option> 
            <option value="Pacific/Kiritimati">Kiritimati [LINT +14:00]</option> 
        </select>
</div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="currency_name">Currency:</label>
    <div class="col-sm-10">
        <select name="currency_name" class="form-control">
            <option  value="" >Select currency</option>
            <option value="America (United States) Dollars - USD">America (United States) Dollars – USD</option>
            <option value="Afghanistan Afghanis - AFN">Afghanistan Afghanis – AFN</option>
            <option value="Albania Leke - ALL">Albania Leke – ALL</option>
            <option value="Algeria Dinars - DZD">Algeria Dinars – DZD</option>
            <option value="Argentina Pesos - ARS">Argentina Pesos – ARS</option>
            <option value="Australia Dollars - AUD">Australia Dollars – AUD</option>
            <option value="Austria Schillings - ATS">Austria Schillings – ATS</option>
             
            <option value="Bahamas Dollars - BSD">Bahamas Dollars – BSD</option>
            <option value="Bahrain Dinars - BHD">Bahrain Dinars – BHD</option>
            <option value="Bangladesh Taka - BDT">Bangladesh Taka – BDT</option>
            <option value="Barbados Dollars - BBD">Barbados Dollars – BBD</option>
            <option value="Belgium Francs - BEF">Belgium Francs – BEF</option>
            <option value="Bermuda Dollars - BMD">Bermuda Dollars – BMD</option>
             
            <option value="Brazil Reais - BRL">Brazil Reais – BRL</option>
            <option value="Bulgaria Leva - BGN">Bulgaria Leva – BGN</option>
            <option value="Canada Dollars - CAD">Canada Dollars – CAD</option>
            <option value="CFA BCEAO Francs - XOF">CFA BCEAO Francs – XOF</option>
            <option value="CFA BEAC Francs - XAF">CFA BEAC Francs – XAF</option>
            <option value="Chile Pesos - CLP">Chile Pesos – CLP</option>
             
            <option value="China Yuan Renminbi - CNY">China Yuan Renminbi – CNY</option>
            <option value="RMB (China Yuan Renminbi) - CNY">RMB (China Yuan Renminbi) – CNY</option>
            <option value="Colombia Pesos - COP">Colombia Pesos – COP</option>
            <option value="CFP Francs - XPF">CFP Francs – XPF</option>
            <option value="Costa Rica Colones - CRC">Costa Rica Colones – CRC</option>
            <option value="Croatia Kuna - HRK">Croatia Kuna – HRK</option>
             
            <option value="Cyprus Pounds - CYP">Cyprus Pounds – CYP</option>
            <option value="Czech Republic Koruny - CZK">Czech Republic Koruny – CZK</option>
            <option value="Denmark Kroner - DKK">Denmark Kroner – DKK</option>
            <option value="Deutsche (Germany) Marks - DEM">Deutsche (Germany) Marks – DEM</option>
            <option value="Dominican Republic Pesos - DOP">Dominican Republic Pesos – DOP</option>
            <option value="Dutch (Netherlands) Guilders - NLG">Dutch (Netherlands) Guilders – NLG</option>
             
            <option value="Eastern Caribbean Dollars - XCD">Eastern Caribbean Dollars – XCD</option>
            <option value="Egypt Pounds - EGP">Egypt Pounds – EGP</option>
            <option value="Estonia Krooni - EEK">Estonia Krooni – EEK</option>
            <option value="Euro - EUR">Euro – EUR</option>
            <option value="Fiji Dollars - FJD">Fiji Dollars – FJD</option>
            <option value="Finland Markkaa - FIM">Finland Markkaa – FIM</option>
             
            <option value="France Francs - FRF*">France Francs – FRF*</option>
            <option value="Germany Deutsche Marks - DEM">Germany Deutsche Marks – DEM</option>
            <option value="Gold Ounces - XAU">Gold Ounces – XAU</option>
            <option value="Greece Drachmae - GRD">Greece Drachmae – GRD</option>
            <option value="Guatemalan Quetzal - GTQ">Guatemalan Quetzal – GTQ</option>
            <option value="Holland (Netherlands) Guilders - NLG">Holland (Netherlands) Guilders – NLG</option>
            <option value="Hong Kong Dollars - HKD">Hong Kong Dollars – HKD</option>
             
            <option value="Hungary Forint - HUF">Hungary Forint – HUF</option>
            <option value="Iceland Kronur - ISK">Iceland Kronur – ISK</option>
            <option value="IMF Special Drawing Right - XDR">IMF Special Drawing Right – XDR</option>
            <option value="India Rupees - INR">India Rupees – INR</option>
            <option value="Indonesia Rupiahs - IDR">Indonesia Rupiahs – IDR</option>
            <option value="Iran Rials - IRR">Iran Rials – IRR</option>
             
            <option value="Iraq Dinars - IQD">Iraq Dinars – IQD</option>
            <option value="Ireland Pounds - IEP*">Ireland Pounds – IEP*</option>
            <option value="Israel New Shekels - ILS">Israel New Shekels – ILS</option>
            <option value="Italy Lire - ITL*">Italy Lire – ITL*</option>
            <option value="Jamaica Dollars - JMD">Jamaica Dollars – JMD</option>
            <option value="Japan Yen - JPY">Japan Yen – JPY</option>
             
            <option value="Jordan Dinars - JOD">Jordan Dinars – JOD</option>
            <option value="Kenya Shillings - KES">Kenya Shillings – KES</option>
            <option value="Korea (South) Won - KRW">Korea (South) Won – KRW</option>
            <option value="Kuwait Dinars - KWD">Kuwait Dinars – KWD</option>
            <option value="Lebanon Pounds - LBP">Lebanon Pounds – LBP</option>
            <option value="Luxembourg Francs - LUF">Luxembourg Francs – LUF</option>
             
            <option value="Malaysia Ringgits - MYR">Malaysia Ringgits – MYR</option>
            <option value="Malta Liri - MTL">Malta Liri – MTL</option>
            <option value="Mauritius Rupees - MUR">Mauritius Rupees – MUR</option>
            <option value="Mexico Pesos - MXN">Mexico Pesos – MXN</option>
            <option value="Morocco Dirhams - MAD">Morocco Dirhams – MAD</option>
            <option value="Netherlands Guilders - NLG">Netherlands Guilders – NLG</option>
             
            <option value="New Zealand Dollars - NZD">New Zealand Dollars – NZD</option>
            <option value="Norway Kroner - NOK">Norway Kroner – NOK</option>
            <option value="Oman Rials - OMR">Oman Rials – OMR</option>
            <option value="Pakistan Rupees - PKR">Pakistan Rupees – PKR</option>
            <option value="Palladium Ounces - XPD">Palladium Ounces – XPD</option>
            <option value="Peru Nuevos Soles - PEN">Peru Nuevos Soles – PEN</option>
             
            <option value="Philippines Pesos - PHP">Philippines Pesos – PHP</option>
            <option value="Platinum Ounces - XPT">Platinum Ounces – XPT</option>
            <option value="Poland Zlotych - PLN">Poland Zlotych – PLN</option>
            <option value="Portugal Escudos - PTE">Portugal Escudos – PTE</option>
            <option value="Qatar Riyals - QAR">Qatar Riyals – QAR</option>
            <option value="Romania New Lei - RON">Romania New Lei – RON</option>
             
            <option value="Romania Lei - ROL">Romania Lei – ROL</option>
            <option value="Russia Rubles - RUB">Russia Rubles – RUB</option>
            <option value="Saudi Arabia Riyals - SAR">Saudi Arabia Riyals – SAR</option>
            <option value="Silver Ounces - XAG">Silver Ounces – XAG</option>
            <option value="Singapore Dollars - SGD">Singapore Dollars – SGD</option>
            <option value="Slovakia Koruny - SKK">Slovakia Koruny – SKK</option>
             
            <option value="Slovenia Tolars - SIT">Slovenia Tolars – SIT</option>
            <option value="South Africa Rand - ZAR">South Africa Rand – ZAR</option>
            <option value="South Korea Won - KRW">South Korea Won – KRW</option>
            <option value="Spain Pesetas - ESP">Spain Pesetas – ESP</option>
            <option value="Special Drawing Rights (IMF) - XDR">Special Drawing Rights (IMF) – XDR</option>
            <option value="Sri Lanka Rupees - LKR">Sri Lanka Rupees – LKR</option>
             
            <option value="Sudan Dinars - SDD">Sudan Dinars – SDD</option>
            <option value="Sweden Kronor - SEK">Sweden Kronor – SEK</option>
            <option value="Switzerland Francs - CHF">Switzerland Francs – CHF</option>
            <option value="Taiwan New Dollars - TWD">Taiwan New Dollars – TWD</option>
            <option value="Thailand Baht - THB">Thailand Baht – THB</option>
            <option value="Trinidad and Tobago Dollars - TTD">Trinidad and Tobago Dollars – TTD</option>
             
            <option value="Tunisia Dinars - TND">Tunisia Dinars – TND</option>
            <option value="Turkey New Lira - TRY">Turkey New Lira – TRY</option>
            <option value="United Arab Emirates Dirhams - AED">United Arab Emirates Dirhams – AED</option>
            <option value="United Kingdom Pounds - GBP">United Kingdom Pounds – GBP</option>
            <option value="United States Dollars - USD">United States Dollars – USD</option>
            <option value="Venezuela Bolivares - VEB">Venezuela Bolivares – VEB</option>
             
            <option value="Vietnam Dong - VND">Vietnam Dong – VND</option>
            <option value="Zambia Kwacha - ZMK">Zambia Kwacha – ZMK</option>
        </select>
</div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="currency_symbol">Currency Symbol:</label>
  <div class="col-sm-10">
       <input type="text" name="currency_symbol" class="form-control" />
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="Contactno">Contact No:</label>
  <div class="col-sm-10">
    <input type="number" class="form-control" id="" name="contact_no" required="" placeholder="Contact No"/>
  </div>
</div>


<?php 
 
     //the status will active for now i will make flow for the then will change 
     // for current time stauts will insert "active" status in hidden fields.
     echo form_hidden('status','active');
 
    //echo '<div class="form-group"><label class="control-label col-sm-2" for="status">Status</label>';
    //echo '<div class="col-sm-10">';
    //$option = array('active'=>'active','inactive'=>'inactive');
    //echo form_dropdown('status',$option,'','class="form-control"') . '</div></div>';
     
    
    echo '<div class="form-group"><label class="control-label col-sm-2" for="submit"></label>';
    echo '<div class="col-sm-10">';
    echo '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
    echo '&nbsp';
    echo form_submit('submit','Create Store','class="btn btn-success"');
    
    echo '</div></div>';
    
    echo form_close();
 
?>
