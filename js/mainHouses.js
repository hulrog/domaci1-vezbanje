/* attach a submit handler to the form */
$("#createHouseForm").submit(function(event) {

    // stop form from refreshing
    event.preventDefault();
  

    var name = $("#name").val();
    var region = $("#region").val();
    var seat = $("#seat").val();

    if(name==''||region==''||seat=='') {
        alert("Please fill all fields.");
        return false;
    }

    $.ajax({
        type: "POST",
        url: "handler/addHouses.php",
        data: {
            name: name,
            seat: seat,
            region: region
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