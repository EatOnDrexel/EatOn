//EatON.js 
//javasript for EatON

//check form input function
function checkForm()
{
	RCal = document.getElementById["RCal"].value;
	RCarb = document.getElementById["RCarb"].value;
	RPro = document.getElementById["RPro"].value;
	RFat = document.getElementById["RFat"].value;
	
	CCarb = document.getElementById["CCarb"].value;
	CPro = document.getElementById["CPro"].value;
	CFat = document.getElementById["CFat"].value;
	
	if(isFinite(RCal) && isFinite(RCarb) && isFinite(RPro) && isFinite(RFat) && isFinite(CCarb) && isFinite(CPro) && isFinite(CFat))
	{
		if((CCarb+CPro+CFat)==100)
		{
			return true;
		}
		else
		{
			alert('Input Error: Consumed input percentage does not add up to 100%');
			return false;
		}
	}
	else
	{
		alert('Input Error: Input not number');
		return false;
	}
}
