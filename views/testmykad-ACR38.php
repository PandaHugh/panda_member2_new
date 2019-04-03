<html>
<head>
<title>MSU MYKAD TESTING SYSTEM</title>
<script src="<?php echo base_url('mykad.js'); ?>" language="javascript" type="text/javascript"> </script>
<script type="text/javascript">
function AddItem1(Text)
{
    var opt = document.createElement("option");
    var n = document.getElementById("SelectMsg").options.length;
    
    document.getElementById("SelectMsg").options.add(opt);
    opt.text = Text;
    document.getElementById("SelectMsg").options[n].selected = true;
}
function AddItem(Text)
{
    var listbox = document.getElementById('SelectMsg');
    var newOption = document.createElement('option'); 
    newOption.value = Text; // The value that this option will have 
    newOption.innerHTML = Text; // The displayed text inside of the <option> tags
    listbox.appendChild(newOption); 
}
function ResetList()
{
    document.getElementById("SelectMsg").options.length = 0;
}
function ReadTest()
{
    res = initMyKAD();
    AddItem("initMyKAD()");

    res = version();
    AddItem("version() " + res);

    res = openReader("ACS ACR38USB 0", "ACS ACR38USBSAM 0");
    AddItem("openReader() " + res);
    
    res = loadMyKAD();
    AddItem("loadMyKAD()" + res);

    // what to read
    setReadHolderName(true);
    setICNo(true);
    setReadOldICNo(true);
    setReadAddress1(true);
    setReadAddress2(true);
    setReadAddress3(true);
    setReadState(true);
    setReadPostCode(true);
    setReadCity(true);
    setReadReligion(true);
    setReadGender(true);
    setReadBirthDate(true);
    setReadBirthPlace(true);
    setReadRace(true);
    setReadCitizenship(true);
    setReadDateIssued(true);
    setReadDateRegistered(true);
    setReadPhoto("C:\\temp\\MYKAD-PHOTO.BMP");
   
    res = readMyKAD();
    AddItem("readMyKAD()" + res);

    AddItem("=====================================================");
    AddItem("holderName():" + holderName());
    AddItem("icNo():" + icNo());
    AddItem("oldICNo():" + oldICNo());
    AddItem("address1():" + address1());
    AddItem("address2():" + address2());
    AddItem("address3():" + address3());
    AddItem("state():" + state());
    AddItem("postcode():" + postcode());
    AddItem("city():" + city());
    AddItem("religion():" + religion());
    AddItem("gender():" + gender());
    AddItem("birthDate():" + birthDate());
    AddItem("birthPlace():" + birthPlace());
    AddItem("race():" + race());
    AddItem("citizenship():" + citizenship());
    AddItem("dateIssued():" + dateIssued());
    AddItem("dateRegistered():" + dateRegistered());
    AddItem("Photo stored at " + "C:\\temp\\MYKAD-PHOTO.BMP");
    AddItem("=====================================================");
    
    res = unloadMyKAD();
    AddItem("unloadMyKAD()" + res);
    
    res = closeReader();
    AddItem("closeReader() " + res);

    res = freeMyKAD();
    AddItem("freeMyKAD()");
    
    alert("Read finished.");
}
</script>
</head>
<body>
<form name="TestMyKADForm" action="RecordMyKAD.php" method="post">
TEST MyKAD<br>
<select name="msglist" id="SelectMsg" size="20" Style="Width: 480"></select>
<br><br>
<button id="idReadMyKAD" type="button" onClick="ReadTest()" Style="Width: 100">READ MyKAD</button>
<button id="ClrList" type="button" onclick="ResetList()" Style="Width: 100">Clear</button>

</form>
</body>
</html>
