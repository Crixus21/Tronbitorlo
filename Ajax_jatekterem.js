function sendComment ()
{
    let textarea = document.getElementById('comment-area');
    let commentText = textarea.value;
    textarea.value = '';
    let charmsgObj = {
        'uid' : selfuid,
        'comment' : commentText,
        'feladat' : 'sendComment'
    };
    
    let charmsg = JSON.stringify(charmsgObj);
    
    let xhr = new XMLHttpRequest();
    xhr.onload = function () {

        let response = JSON.parse(this.responseText);
        
        for(let i = response.length - 1; i >= 0; i-- )
        {
            let newComment = new Comment(response[i].knev, response[i].charimg, response[i].beginDate, response[i].charmsg);
            commentList.unshift(newComment);
            
        }
        commentList.splice(30);
        
        displayComments(1);
        
    };
    
    xhr.open('POST', 'control.php', true);
    xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8');
    xhr.send(charmsg);
}


function refreshCommentList()
{
    
    let dataObj = {
        "feladat" : "getCommentList"
    };
    
    let data = JSON.stringify(dataObj);
    
    let xhr = new XMLHttpRequest();
    
    xhr.onload = function () {
//        let testDiv = document.getElementById('test');
//        testDiv.innerHTML = this.responseText;
        let response = JSON.parse(this.responseText);
        
        for(let i = response.length - 1; i >= 0; i-- )
        {
            let newComment = new Comment(response[i].knev, response[i].charimg, response[i].beginDate, response[i].charmsg);
            commentList.unshift(newComment);
            
        }
        commentList.splice(30);
        
        displayComments(1);
        
    };
    
    xhr.open('POST', 'control.php', true);
    xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8');
    xhr.send(data);
}