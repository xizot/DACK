function DeletePost(id) {

    var rs = confirm("Bạn chắc chắn muốn xóa bài viết này?");
    if(rs == true)
    {
        $("#" + id).parent().remove();
        var xmlhttp = new XMLHttpRequest();
    
        xmlhttp.open("GET", "DeletePost.php?postID=" + id, true);
        xmlhttp.send();
    }
}

// Like & unLike
function Like(postID, userID) {



    var audio = new Audio('1.mp3');
    audio.play();


    var link = "like.php?postID=" + postID + "&userID=" + userID;
    var check = $("#post" + postID).val();
    if (check == '1') {
        $("#post" + postID).val('0');
        $("#post" + postID).html("<i class='far fa-thumbs-up'></i><span class='repon'> Like</span>");
        link = "unlike.php?postID=" + postID + "&userID=" + userID;
    }
    else if (check == '0') {
        $("#post" + postID).val('1');
        $("#post" + postID).html("<i class='fas fa-thumbs-up'></i><span class='repon'> Liked</span>");
    }


    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            $("#numLike" + postID).text(this.responseText + (parseInt(this.responseText) > 1 ? " Likes" : " Like"));
        }
    };

    xmlhttp.open("GET", link, true);
    xmlhttp.send();
}


function getComment(postID) {
    var check = $("#btnComment" + postID).val();

    if (check == '0') {
        $("#btnComment" + postID).val('1');
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                $("#comment" + postID).append(this.responseText);
            }
        };

        xmlhttp.open("GET", "./comment.php?postID=" + postID, true);
        xmlhttp.send();
    }
    else if (check == '1') {
        $("#btnComment" + postID).val('0');
        $("#boxInput" + postID).remove();
        var contentToRemove = document.querySelectorAll("#cmt" + postID);
        $(contentToRemove).remove();
    }
}

function sendComment(postID, userID, event) {
    var keyPressed = event.keyCode || event.which;

    //if ENTER is pressed
    if (keyPressed == 13) {
        if ($(".cmtInput" + postID).val() != "") {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    $("#boxInput" + postID).before(this.responseText);
                    var numcmt = $("#numCmt" + postID).text();
                    numcmt = numcmt.split(" ");
                    numcmt = parseInt(numcmt[0]) + 1;



                    $("#numCmt" + postID).text(numcmt > 1 ? numcmt + " Comments" : numcmt + " Comment");
                }
            };

            xmlhttp.open("GET", "./sendComment.php?postID=" + postID + "&userID=" + userID + "&status=" + $(".cmtInput" + postID).val(), true);
            xmlhttp.send();
        }
        keyPressed = null;
        $(".cmtInput" + postID).val(' ');

    }
    else {
        return false;
    }

}


function GetMessage(from, to) {

    var removeUser1 = document.querySelectorAll("#user2");
    $(removeUser1).remove();
    var removeUser2 = document.querySelectorAll("#user1");
    $(removeUser2).remove();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            $(".msgRight").append(this.responseText);


            $('.msgWrite').html('<img class="img" src="avt.php?id=' + from + '&for=avt" alt=" "><input style="text-align:center" type="text" id="chat" onkeyup="SendMessage(' + to + ',event)">');
        }
    };
    xmlhttp.open("GET", "./LoadMessage.php?fromID=" + from + "&toID=" + to, true);
    xmlhttp.send();
    // location.replace("./message.php?toID=" + to);
    // location.reloadPage();
}


function SendMessage(ID, event) {
    var keyPressed = event.keyCode || event.which;

    //if ENTER is pressed
    if (keyPressed == 13) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "./sendMessage.php?to=" + ID + "&content=" + $("#chat").val(), true);
        xmlhttp.send();
        keyPressed = null;

        var xmlhttp1 = new XMLHttpRequest();
        xmlhttp1.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                $(".msgRight").append(this.responseText);
            }
        };
        xmlhttp1.open("GET", "./user1.php?content=" + $("#chat").val(), true);
        xmlhttp1.send();
        $("#chat").val(' ');

    }
    else {
        return false;
    }


}



function Setprivacy(selection, postID) {
    if (selection == '0') {
        $("#pri" + postID).html('<i class="fas fa-lock"></i>');

    }
    if (selection == '1') {
        $("#pri" + postID).html('<i class="fas fa-user-friends"></i>');
    }
    if (selection == '2') {
        $("#pri" + postID).html('<i class="fas fa-globe-europe"></i>');

    }

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "./setPrivacy.php?privacy=" + selection + "&postID=" + postID, true);
    xmlhttp.send();
}

function Pagination(numPage, forpg, id) {
    for (let index = 0; index <= 5; index++) {
        var a = "page" + index;
        $("#" + a).attr('class', 'page-item');
    }
    $("#page" + numPage).attr('class', 'page-item active');


    var removeUser1 = document.querySelectorAll(".box-status-content");
    $(removeUser1).remove();
    LoadPage(numPage, 5, forpg, id);
}


function LoadPage(pageNum, limit, forpg, prID) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            $(".box-status").append(this.responseText);
        }
    };

    xmlhttp.open("GET", "./Pagination.php?limit=" + limit + "&pagenum=" + pageNum + "&frmID=" + prID + "&for=" + forpg, true);
    xmlhttp.send();
}


function removeNotiFy(byId, PostID, Type) {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", "./removeNotify.php?postID=" + PostID + "&byID=" + byId + "&type=" + Type, true);
    xmlhttp.send();

}
function seenNotiFy(byId, PostID, Type) {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", "./seenNotification.php?postID=" + PostID + "&byID=" + byId + "&type=" + Type, true);
    xmlhttp.send();

}


function DeleteMessage(msgID) {
    var rs = confirm("Bạn chắc chắn muốn xóa tin nhắn này? ");
    if(rs == true)
    {
        $(".msg" + msgID).remove();
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "./deleteMessage.php?msgID=" + msgID, true);
        xmlhttp.send();
    }
 
}

function reloadPage() {
    var currentDocumentTimestamp = new Date(performance.timing.domLoading).getTime();
    // Current Time //
    var now = Date.now();
    // Total Process Lenght as Minutes //
    var oneMinute = 1 * 1000;
    // End Time of Process //
    var plusOneMinute = currentDocumentTimestamp + oneMinute;
    if (now > plusOneMinute) {
        location.reload();
    }
}


function DeleteAllMessage(fromID, toID)
{
    var rs = confirm("Bạn chắc chắn muốn xóa cuộc trò chuyện này?");
    if(rs == true)
    {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "./deleteAllMessage.php?fromID="+fromID+"&toID="+toID, true);
        xmlhttp.send();
        $("#Last"+toID).remove();
        var removeUser1 = document.querySelectorAll("#user2");
        $(removeUser1).remove();
        var removeUser2 = document.querySelectorAll("#user1");
        $(removeUser2).remove();
    }
}


