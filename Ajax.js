function sendComment (mode)
{
    if(mode === 'jatekter')
    {
        var feladat = 'sendComment';
        let textarea = document.getElementById('comment-area');
        var commentText = textarea.value;
        textarea.value = '';
        
        let commentCont = document.getElementsByClassName('comment-container')[0];
        let pagi = document.getElementsByClassName('pagination')[0];

        commentCont.style.visibility = 'hidden';
        commentCont.style.opacity = '0';
        pagi.style.visibility = 'hidden';
        pagi.style.opacity = '0';
        
        timerWatcher = true;
        setTimeout(function () {
            timerWatcher = false;
            
        }, 500);
    } else 
    if(mode === 'kocsma')
    {
        var feladat = 'sendKocsmaComment';
        let textarea = document.getElementById('kocsmaComment');
        var commentText = textarea.value;
        textarea.value = '';
    }
    
    let charmsgObj = {
        'comment' : commentText,
        'feladat' : feladat
    };
    
    let charmsg = JSON.stringify(charmsgObj);
    
    let xhr = new XMLHttpRequest();
    xhr.onload = function () {
        
        let response = JSON.parse(this.responseText);

        if(mode === 'jatekter')
        {
            commentList = [];
            for(let i = response.length - 1; i >= 0; i-- )
            {
                let newComment = new Comment(response[i].knev, response[i].charimg, response[i].beginDate, response[i].charmsg);
                commentList.unshift(newComment);

            }
            commentList.splice(30);
            let timerStatus = timerWatcher === true ? 'tooEarly' : 'afterTransition';

            displayComments(1, '', timerStatus);
        } else
        if(mode === 'kocsma')
        {
            kocsmaCommentList = [];
            for(let i = response.length - 1; i >= 0; i-- )
            {
                let newKocsmaComment = new KocsmaComment(response[i].knev, response[i].kTime, response[i].kocsmamsg);
                kocsmaCommentList.unshift(newKocsmaComment);

            }
            kocsmaCommentList.splice(40);

            displayKocsma();

            let chatbox = document.getElementById('chatbox');
            chatbox.scrollTop = chatbox.scrollHeight;
        }
    };
    
    xhr.open('POST', 'control.php', true);
    xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8');
    xhr.withCredentials = true;
    xhr.send(charmsg);
}


function refreshCommentList(mode, scrollmode)
{
    if (mode === 'jatekter')
    {
        var feladat = 'getJatekCommentList';
        let commentCont = document.getElementsByClassName('comment-container')[0];
        let pagi = document.getElementsByClassName('pagination')[0];

        commentCont.style.visibility = 'hidden';
        commentCont.style.opacity = '0';
        pagi.style.visibility = 'hidden';
        pagi.style.opacity = '0';
        
        timerWatcher = true;
        setTimeout(function () {
            timerWatcher = false;
            
        }, 500);
    } else
    if(mode === 'kocsma')
    {
	var feladat = 'getKocsmaCommentList';
    }

    
    
    let dataObj = {
        "feladat" : feladat
    };
    
    let data = JSON.stringify(dataObj);
    
    let xhr = new XMLHttpRequest();
    
    xhr.onload = function () {
        let response = JSON.parse(this.responseText);
        if(mode === 'jatekter')
        {
            commentList = [];
            for(let i = response.length - 1; i >= 0; i-- )
            {
                let newComment = new Comment(response[i].knev, response[i].charimg, response[i].beginDate, response[i].charmsg);
                commentList.unshift(newComment);

            }
            commentList.splice(30);
            
            let timerStatus = timerWatcher === true ? 'tooEarly' : 'afterTransition';
            
            displayComments(1, '', timerStatus);
        } else
        if(mode === 'kocsma')
        {
            kocsmaCommentList = [];
            for(let i = response.length - 1; i >= 0; i-- )
            {
                let newKocsmaComment = new KocsmaComment(response[i].knev, response[i].kTime, response[i].kocsmamsg);
                kocsmaCommentList.unshift(newKocsmaComment);

            }
            kocsmaCommentList.splice(40);

            displayKocsma();
            if(scrollmode === 1)
            {
                let chatbox = document.getElementById('chatbox');
                chatbox.scrollTop = chatbox.scrollHeight;
            }
        }
    };
    
    xhr.open('POST', 'control.php', true);
    xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8');
    xhr.send(data);
}