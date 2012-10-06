<?php
/*
 * copyright (c) 2009 MDBitz - Matthew John Denton - mdbitz.com
 *
 * This file is part of HarvestAPI.
 *
 * HarvestAPI is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * HarvestAPI is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with HarvestAPI. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Harvest_Currency
 *
 * This file contains the class Harvest_Currency
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.harvest
 */

/**
 * Harvest_Currency defines the currency options supported by Harvest
 *
 * @package com.mdbitz.harvest
 */
class Harvest_Currency
{
    /**
     *  United States Dollars
     */
    const USD = "United States Dollars - USD";

    /**
     *  United States Dollars
     */
    const UNITED_STATES_DOLLARS = "United States Dollars - USD";

    /**
     *  Euro
     */
    const EUR = "EURO - EUR";

    /**
     *  Euro
     */
    const EURO = "EURO - EUR";

    /**
     *  United Kingdom Pounds
     */
    const GBP = "United Kingdom Pounds - GBP";

    /**
     *  United Kingdom Pounds
     */
    const UNITED_KINGDOM_POUNDS = "United Kingdom Pounds - GBP";

    /**
     *  Canada Dollars
     */
    const CAD = "Canada Dollars - CAD";

    /**
     *  Canada Dollars
     */
    const CANADA_DOLLARS = "Canada Dollars - CAD";

    /**
     *  Australia Dollars
     */
    const AUD = "Australia Dollars - AUD";

    /**
     *  Australia Dollars
     */
    const AUSTRALIA_DOLLARS = "Australia Dollars - AUD";

    /**
     *  Japan Yen
     */
    const JPY = "Japan Yen - JPY";

    /**
     *  Japan Yen
     */
    const JAPAN_YEN = "Japan Yen - JPY";

    /**
     *  India Rupees
     */
    const INR = "India Rupees - INR";

    /**
     *  India Rupees
     */
    const INDIA_RUPEES = "India Rupees - INR";

    /**
     *  New Zealand Dollars
     */
    const NZD = "New Zealand Dollars - NZD";

    /**
     *  New Zealand Dollars
     */
    const NEW_ZEALAND_DOLLARS = "New Zealand Dollars - NZD";

    /**
     *  Switzerland Francs
     */
    const CHF = "Switzerland Francs - CHF";

    /**
     *  Switzerland Francs
     */
    const SWITZERLAND_FRANCS = "Switzerland Francs - CHF";

    /**
     *  South Africa Rand
     */
    const ZAR = "South Africa Rand - ZAR";

    /**
     *  South Africa Rand
     */
    const SOUTH_AFRICA_RAND = "South Africa Rand - ZAR";

    /**
     *  Afghanistan Afghanis
     */
    const AFN = "Afghanistan Afghanis - AFN";

    /**
     *  Afghanistan Afghanis
     */
    const AFGHANISTAN_AFGHANIS = "Afghanistan Afghanis - AFN";

    /**
     *  Albania Leke
     */
    const ALL = "Albania Leke - ALL";

    /**
     *  Albania Leke
     */
    const ALBANIA_LEKE = "Albania Leke - ALL";

    /**
     *  Algeria Dinars
     */
    const DZD = "Algeria Dinars - DZD";

    /**
     *  Algeria Dinars
     */
    const ALEGERIA_DINARS = "Algeria Dinars - DZD";

    /**
     *  Argentina Pesos
     */
    const ARS = "Argentina Pesos - ARS";

    /**
     *  Argentina Pesos
     */
    const ARGENTINA_PESOS = "Argentina Pesos - ARS";

    /**
     *  Bahamas Dollars
     */
    const BSD = "Bahamas Dollars - BSD";

    /**
     *  Bahamas Dollars
     */
    const BAHAMAS_DOLLARS = "Bahamas Dollars - BSD";

    /**
     *  Bahrain Dinars
     */
    const BHD = "Bahrain Dinars - BHD";

    /**
     *  Bahrain Dinars
     */
    const BAHRAIN_DINARS = "Bahrain Dinars - BHD";

    /**
     *  Bangladesh Taka
     */
    const BDT = "Bangladesh Taka - BDT";

    /**
     *  Bangladesh Taka
     */
    const BANGLADESH_TAKA = "Bangladesh Taka - BDT";

    /**
     *  Barbados Dollars
     */
    const BBD = "Barbados Dollars - BBD";

    /**
     *  Barbados Dollars
     */
    const BARBADOS_DOLLARS = "Barbados Dollars - BBD";

    /**
     *  Belize Dollar
     */
    const BZD = "Belize Dollar - BZD";

    /**
     *  Belize Dollar
     */
    const BELIZE_DOLLAR = "Belize Dollar - BZD";

    /**
     *  Bermuda Dollars
     */
    const BMD = "Bermuda Dollars - BMD";

    /**
     *  Bermuda Dollars
     */
    const BERMUDA_DOLLARS = "Bermuda Dollars - BMD";

    /**
     *  Brazil Reais
     */
    const BRL = "Brazil Reais - BRL";

    /**
     *  Brazil Reais
     */
    const BRAZIL_REAIS = "Brazil Reais - BRL";

    /**
     *  Bulgaria Leva
     */
    const BGN = "Bulgaria Leva - BGN";

    /**
     *  Bulgaria Leva
     */
    const BULGARIA_LEVA = "Bulgaria Leva - BGN";

    /**
     *  Chile Pesos
     */
    const CLP = "Chile Pesos - CLP";

    /**
     *  Chile Pesos
     */
    const CHILE_PESOS = "Chile Pesos - CLP";

    /**
     *  China Yuan Renminbi
     */
    const CNY = "China Yuan Renminbi - CNY";

    /**
     *  China Yuan Renminbi
     */
    const CHINA_YUAN_RENMINBI = "China Yuan Renminbi - CNY";

    /**
     *  Colombia Pesos
     */
    const COP = "Colombia Pesos - COP";

    /**
     *  Colombia Pesos
     */
    const COLOMBIA_PESOS = "Colombia Pesos - COP";

    /**
     *  Costa Rica Colones
     */
    const CRC = "Costa Rica Colones - CRC";

    /**
     *  Costa Rica Colones
     */
    const COSTA_RICA_COLONES = "Costa Rica Colones - CRC";

    /**
     *  Croatia Kuna
     */
    const HRK = "Croatia Kuna - HRK";

    /**
     *  Croatia Kuna
     */
    const CROATIA_KUNA = "Croatia Kuna - HRK";

    /**
     *  Cyprus Pounds
     */
    const CYP = "Cyprus Pounds - CYP";

    /**
     *  Cyprus Pounds
     */
    const CYPRUS_POUNDS = "Cyprus Pounds - CYP";

    /**
     *  Czech Republic Koruny
     */
    const CZK = "Czech Republic Koruny - CZK";

    /**
     *  Czech Republic Koruny
     */
    const CZECH_REPUBLIC_KORUNY = "Czech Republic Koruny - CZK";

    /**
     *  Dominican Republic Pesos
     */
    const DOP = "Dominican Republic Pesos - DOP";

    /**
     *  Dominican Republic Pesos
     */
    const DOMINICAN_REPUBLIC_PESOS = "Dominican Republic Pesos - DOP";

    /**
     *  Danish Krone
     */
    const DKK = "Danish Krone - DKK";

    /**
     *  Danish Krone
     */
    const DANISH_KRONE = "Danish Krone - DKK";

    /**
     *  Eastern Caribbean Dollars
     */
    const XCD = "Eastern Caribbean Dollars - XCD";

    /**
     *  Eastern Caribbean Dollars
     */
    const EASTERN_CARIBBEAN_DOLLARS = "Eastern Caribbean Dollars - XCD";

    /**
     *  Egypt Pounds
     */
    const EGP = "Egypt Pounds - EGP";

    /**
     *  Egypt Pounds
     */
    const EGYPT_POUNDS = "Egypt Pounds - EGP";

    /**
     *  Estonia Krooni
     */
    const EEK = "Estonia Krooni - EEK";

    /**
     *  Estonia Krooni
     */
    const ESTONIA_KROONI = "Estonia Krooni - EEK";

    /**
     *  Fiji Dollars
     */
    const FJD = "Fiji Dollars - FJD";

    /**
     *  Fiji Dollars
     */
    const FIJI_DOLLARS = "Fiji Dollars - FJD";

    /**
     *  Hong Kong Dollars
     */
    const HKD = "Hong Kong Dollars - HKD";

    /**
     *  Hong Kong Dollars
     */
    const HONG_KONG_DOLLARS = "Hong Kong Dollars - HKD";

    /**
     *  Hungary Forint
     */
    const HUF = "Hungary Forint - HUF";

    /**
     *  Hungary Forint
     */
    const HUNGARY_FORINT = "Hungary Forint - HUF";

    /**
     *  Iceland Kronur
     */
    const ISK = "Iceland Kronur - ISK";

    /**
     *  Iceland Kronur
     */
    const ICELAND_KRONUR = "Iceland Kronur - ISK";

    /**
     *  Indonesia Rupiahs
     */
    const IDR = "Indonesia Rupiahs - IDR";

    /**
     *  Indonesia Rupiahs
     */
    const INDONESIA_RUPIAHS = "Indonesia Rupiahs - IDR";

    /**
     *  Iran Rials
     */
    const IRR = "Iran Rials - IRR";

    /**
     *  Iran Rials
     */
    const IRAN_RIALS = "Iran Rials - IRR";

    /**
     *  Iraq Dinars
     */
    const IQD = "Iraq Dinars - IQD";

    /**
     *  Iraq Dinars
     */
    const IRAQ_DINARS = "Iraq Dinars - IQD";

    /**
     *  Israel New Shekels
     */
    const ILS = "Israel New Shekels - ILS";

    /**
     *  Israel New Shekels
     */
    const ISRAEL_NEW_SHEKELS = "Israel New Shekels - ILS";

    /**
     *  Jamaica Dollars
     */
    const JMD = "Jamaica Dollars - JMD";

    /**
     *  Jamaica Dollars
     */
    const JAMAICA_DOLLARS = "Jamaica Dollars - JMD";

    /**
     *  Jordan Dinars
     */
    const JOD = "Jordan Dinars - JOD";

    /**
     *  Jordan Dinars
     */
    const JORDAN_DINARS = "Jordan Dinars - JOD";

    /**
     *  Kenya Shillings
     */
    const KES = "Kenya Shillings - KES";

    /**
     *  Kenya Shillings
     */
    const KENYA_SHILLINGS = "Kenya Shillings - KES";

    /**
     *  Korea (South) Won
     */
    const KRW = "Korea (South) Won - KRW";

    /**
     *  Korea (South) Won
     */
    const KOREA_SOUTH_WON = "Korea (South) Won - KRW";

    /**
     *  Kuwait Dinars
     */
    const KWD = "Kuwait Dinars - KWD";

    /**
     *  Kuwait Dinars
     */
    const KUWAIT_DINARS = "Kuwait Dinars - KWD";

    /**
     *  Latvian Lat
     */
    const LVL = "Latvian Lat - LVL";

    /**
     *  Latvian Lat
     */
    const LATVIAN_LAT = "Latvian Lat - LVL";

    /**
     *  Lebanon Pounds
     */
    const LBP = "Lebanon Pounds - LBP";

    /**
     *  Lebanon Pounds
     */
    const LEBANON_POUNDS = "Lebanon Pounds - LBP";

    /**
     *  Malaysia Ringgits
     */
    const MYR = "Malaysia Ringgits - MYR";

    /**
     *  Malaysia Ringgits
     */
    const MALAYSIA_RINGGITS = "Malaysia Ringgits - MYR";

    /**
     *  Malta Liri
     */
    const MTL = "Malta Liri - MTL";

    /**
     *  Malta Liri
     */
    const MALTA_LIRI = "Malta Liri - MTL";

    /**
     *  Mauritius Rupees
     */
    const MUR = "Mauritius Rupees - MUR";

    /**
     *  Mauritius Rupees
     */
    const MAURITIUS_RUPEES = "Mauritius Rupees - MUR";

    /**
     *  Mexico Pesos
     */
    const MXN = "Mexico Pesos - MXN";

    /**
     *  Mexico Pesos
     */
    const MEXICO_PESOS = "Mexico Pesos - MXN";

    /**
     *  Morocco Dirhams
     */
    const MAD = "Morocco Dirhams - MAD";

    /**
     *  Morocco Dirhams
     */
    const MOROCCO_DIRHAMS = "Morocco Dirhams - MAD";

    /**
     *  Nigerian Naira
     */
    const NGN = "Nigerian Naira - NGN";

    /**
     *  Nigerian Naira
     */
    const NIGERIAN_NAIRA = "Nigerian Naira - NGN";

    /**
     *  Norway Kroner
     */
    const NOK = "Norway Kroner - NOK";

    /**
     *  Norway Kroner
     */
    const NORWAY_KRONER = "Norway Kroner - NOK";

    /**
     *  Oman Rials
     */
    const OMR = "Oman Rials - OMR";

    /**
     *  Oman Rials
     */
    const OMAN_RIALS = "Oman Rials - OMR";

    /**
     *  Pakistan Rupees
     */
    const PKR = "Pakistan Rupees - PKR";

    /**
     *  Pakistan Rupees
     */
    const PAKISTAN_RUPEES = "Pakistan Rupees - PKR";

    /**
     *  Papua New Guinea Kina
     */
    const PGK = "Papua New Guinea Kina - PGK";

    /**
     *  Papua New Guinea Kina
     */
    const PAPUA_NEW_GUINEA_KINA = "Papua New Guinea Kina - PGK";

    /**
     *  Paraguayan Guarani
     */
    const PYG = "Paraguayan Guarani - PYG";

    /**
     *  Paraguayan Guarani
     */
    const PARAGUAYAN_GUARANI = "Paraguayan Guarani - PYG";

    /**
     *  Peru Nuevos Soles
     */
    const PEN = "Peru Nuevos Soles - PEN";

    /**
     *  Peru Nuevos Soles
     */
    const PERU_NUEVOS_SOLES = "Peru Nuevos Soles - PEN";

    /**
     *  Philippines Pesos
     */
    const PHP = "Philippines Pesos - PHP";

    /**
     *  Philippines Pesos
     */
    const PHILIPPINES_PESOS = "Philippines Pesos - PHP";

    /**
     *  Poland Zlotych
     */
    const PLN = "Poland Zlotych - PLN";

    /**
     *  Poland Zlotych
     */
    const POLAND_ZLOTYCH = "Poland Zlotych - PLN";

    /**
     *  Qatar Riyals
     */
    const QAR = "Qatar Riyals - QAR";

    /**
     *  Qatar Riyals
     */
    const QATAR_RIYALS = "Qatar Riyals - QAR";

    /**
     *  Romania New Lei
     */
    const RON = "Romania New Lei - RON";

    /**
     *  Romania New Lei
     */
    const ROMANIA_NEW_LEI = "Romania New Lei - RON";

    /**
     *  Russia Rubles
     */
    const RUB = "Russia Rubles - RUB";

    /**
     *  Russia Rubles
     */
    const RUSSIA_RUBLES = "Russia Rubles - RUB";

    /**
     *  Saudi Arabia Riyals
     */
    const SAR = "Saudi Arabia Riyals - SAR";

    /**
     *  Saudi Arabia Riyals
     */
    const SAUDI_ARABIA_RIYALS = "Saudi Arabia Riyals - SAR";

    /**
     *  Singapore Dollars
     */
    const SGD = "Singapore Dollars - SGD";

    /**
     *  Singapore Dollars
     */
    const SINGAPORE_DOLLARS = "Singapore Dollars - SGD";

    /**
     *  Slovakia Koruny
     */
    const SKK = "Slovakia Koruny - SKK";

    /**
     *  Slovakia Koruny
     */
    const SLOVAKIA_KORUNY = "Slovakia Koruny - SKK";

    /**
     *  South Korea Won
     */
    const SOUTH_KOREA_WON = "South Korea Won - KRW";

    /**
     *  Sri Lanka Rupees
     */
    const LKR = "Sri Lanka Rupees - LKR";

    /**
     *  Sri Lanka Rupees
     */
    const SRI_LANKA_RUPEES = "Sri Lanka Rupees - LKR";

    /**
     *  Sudan Pounds
     */
    const SDG = "Sudan Pounds - SDG";

    /**
     *  Sudan Pounds
     */
    const SUDAN_POUNDS = "Sudan Pounds - SDG";

    /**
     *  Swedish krona
     */
    const SEK = "Swedish krona - SEK";

    /**
     *  Swedish krona
     */
    const SWEDISH_KRONA = "Swedish krona - SEK";

    /**
     *  Taiwan New Dollars
     */
    const TWD = "Taiwan New Dollars - TWD";

    /**
     *  Taiwan New Dollars
     */
    const TAIWAN_NEW_DOLLARS = "Taiwan New Dollars - TWD";

    /**
     *  Thailand Baht
     */
    const THB = "Thailand Baht - THB";

    /**
     *  Thailand Baht
     */
    const THAILAND_BAHT = "Thailand Baht - THB";

	/**
	 *  Trinidad and Tobago Dollars
	 */
	const TTD = "Trinidad and Tobago Dollars - TTD";

	/**
	 *  Trinidad and Tobago Dollars
	 */
	const TRINIDAD_AND_TOBAGO_DOLLARS = "Trinidad and Tobago Dollars - TTD";
	
	/**
	 *  Tunisia Dinars
	 */
	const TND = "Tunisia Dinars - TND";

	/**
	 *  Tunisia Dinars
	 */
	const TUNISIA_DINARS = "Tunisia Dinars - TND";

	/*
	 *  Turkey New Lira
	 */
	//const TRY = "Turkey New Lira - TRY";

	/**
	 *  Turkey New Lira
	 */
	const TURKEY_NEW_LIRA = "Turkey New Lira - TRY";	

    /**
     *  United Arab Emirates Dirham
     */
    const AED = "United Arab Emirates Dirham - AED";

    /**
     *  United Arab Emirates Dirham
     */
    const UNITED_ARAB_EMIRATES_DIRHAM = "United Arab Emirates Dirham - AED";

    /**
     *  Uruguayan peso
     */
    const UYU = "Uruguayan peso - UYU";

    /**
     *  Uruguayan peso
     */
    const URUGUAYAN_PESO = "Uruguayan peso - UYU";

    /**
     *  Ukrainian hryvnia
     */
    const UAH = "Ukrainian hryvnia - UAH";

    /**
     *  Ukrainian hryvnia
     */
    const UKRAINIAN_HRYVNIA = "Ukrainian hryvnia - UAH";

    /**
     *  Venezuela Bolivares
     */
    const VEB = "Venezuela Bolivares - VEB";

    /**
     *  Venezuela Bolivares
     */
    const VENEZUELA_BOLIVARES = "Venezuela Bolivares - VEB";

    /**
     *  Vietnam Dong
     */
    const VND = "Vietnam Dong - VND";

    /**
     *  Vietnam Dong
     */
    const VIETNAM_DONG = "Vietnam Dong - VND";

    /**
     *  Zambia Kwacha
     */
    const ZMK = "Zambia Kwacha - ZMK";

    /**
     *  Zambia Kwacha
     */
    const ZAMBIA_KWACHA = "Zambia Kwacha - ZMK";

}