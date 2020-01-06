
var t = new Title("CONNECT WITH ME!");
window.onload=function() {
    document.getElementById("button").disabled=false;
    document.getElementById("button").style.backgroundColor = "grey";
    var textArea = document.getElementsByClassName("dropDownTextArea");
    for (var i = 0; i < 3; i++){
        textArea[i].style.display = 'none';
    }
}

function ChangeColor (checkbox) {
    var selectedRow = checkbox.parentNode.parentNode;
    var button = document.getElementById("button");
    if (checkbox.checked) {

        if(document.getElementsByTagName("input")[0].checked||document.getElementsByTagName("input")[1].checked||document.getElementsByTagName("input")[2].checked){

            button.disabled = false;
            button.style.backgroundColor = "orange";
        }

        else{
            button.disabled = true;
            button.style.backgroundColor = "grey";
        }
        selectedRow.style.backgroundColor = "#fffd8a";
    }else {
        if(document.getElementsByTagName("input")[0].checked||document.getElementsByTagName("input")[1].checked||document.getElementsByTagName("input")[2].checked){

            button.disabled = false;
            button.style.backgroundColor = "orange";
        }

        else{
            button.disabled = true;
            button.style.backgroundColor = "grey";
        }
        selectedRow.style.backgroundColor = "white";
    }
}

var count=0;
function Click (down){

    count++;
    if(count%2==0){
        var currentRow = down.parentNode.parentNode;
        var nextRow = currentRow.parentNode.rows[ currentRow.rowIndex + 1 ];
        nextRow.style.display = "none";
    }
    else{ var currentRow = down.parentNode.parentNode;
        var nextRow = currentRow.parentNode.rows[ currentRow.rowIndex + 1 ];
        nextRow.style.display = "";
        }

}




//original part


function Title(t1)
{ this.mytitle = t1;
}

Title.prototype.getName = function ()
{
    return (this.mytitle);
}

var socialMedia = {
    facebook : 'http://facebook.com',
    twitter: 'http://twitter.com',
    flickr: 'http://flickr.com',
    youtube: 'http://youtube.com'
};



