    refreshCommentList('kocsma', 1);    

    const iv = setInterval(refreshCommentList, 2500, 'kocsma', 0);

    let kInput = document.getElementById('kocsmaComment');
    kInput.addEventListener('keypress', function(event) {
        if(event.key === 'Enter') {
            event.preventDefault();
            sendComment('kocsma');
        }
    });
    
    
    