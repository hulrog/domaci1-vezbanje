/* attach a submit handler to the form */
$("#createCharForm").submit(function(event) {

    // stop form from refreshing
    event.preventDefault();
  

    var name = $("#name").val();
    var houseID = $("#houseID").val();
    var title = $("#title").val();
    var gender = $("#gender").val();

    if(name==''||houseID==''||title==''||gender=='') {
        alert("Please fill all fields.");
        return false;
    }

    $.ajax({
        type: "POST",
        url: "handler/add.php",
        data: {
            name: name,
            houseID: houseID,
            title: title,
            gender: gender
        },
        cache: false,
        success: function(data) {
            alert(data);
        },
        error: function(xhr, status, error) {
            console.error(xhr);
        }
    });
  });

//for the sorting
function sortTable() {
    var table, rows, switchFlag, switchable;
    var name1, name2;
    var i;
    table = document.getElementById("charactersTable");
    
    switchFlag = true;
    while (switchFlag) {
        switchFlag = false;//reset the switch at
        rows = table.rows;//array of rows
        //i=1 because i=0 is the header
        for (i = 1; i < (rows.length - 1); i++) {
            switchable = false;

            name1 = rows[i].getElementsByTagName("td")[1];//1 because 0 is id, 1 is name
            name2 = rows[i + 1].getElementsByTagName("td")[1];
            //if the names should switch
            if (name1.innerHTML.toLowerCase() > name2.innerHTML.toLowerCase()) {
            switchable = true;
            break;
            }
        }
        if (switchable) {
            //switch the rows
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switchFlag = true;
        }
    }

    evenOddColors();
}  

function evenOddColors(){
    var colorIterator;
    table = document.getElementById("charactersTable");
    rows = table.rows;


    //rows[colorIterator].style.display != "none"
    for(colorIterator=1; colorIterator < rows.length; colorIterator++) {
        if(colorIterator%2==0){
            rows[colorIterator].style.backgroundColor = "#debc89";
        }else{
            rows[colorIterator].style.backgroundColor = "#efdabd";
        }
    }


}

//filtering 
function search() {
  
    searchValue = document.getElementById("search");
    filter = searchValue.value.toLowerCase(); //because the names contain both upper and lower case letters

    characterTable = document.getElementById("charactersTable");
    rows = characterTable.rows;

    var characterName, i, txtValue;
    var i;
    
    for (i = 1; i < rows.length; i++) {
        characterName = rows[i].getElementsByTagName("td")[1];//1 is the index of the name column
        txtValue = characterName.innerText;
        
        if (txtValue.toLowerCase().indexOf(filter) > -1) { //ako mogu ta slova da se nadju u nizu
            rows[i].style.display = ""; //pokazi one koji matchuju 
        } else {
            rows[i].style.display = "none"; //sakrij one koji ne matchuju
        }
    }

    //rows[colorIterator].style.display != "none"
    var displayedIterator;
    var colorIterator = 1;
    var displayedRow;
    for(displayedIterator=1; displayedIterator < rows.length; displayedIterator++) {
        if(rows[displayedIterator].style.display != "none"){
            displayedRow = rows[displayedIterator];
            if(colorIterator%2 == 0){
                displayedRow.style.backgroundColor = "#debc89";
            }else{
                displayedRow.style.backgroundColor = "#efdabd";
            }
            colorIterator++;
        }
    }
    
}


//suggestions for names
function canonNames(str) {
    if (str.length == 0) {//ako nismo stavili nista, nece se pokazivati nista
        document.getElementById("suggestedName").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) { //4 znaci complete , 200 ok
                document.getElementById("suggestedName").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "handler/names.php?enteredName=" + str, true);
        xmlhttp.send();
    }
}
