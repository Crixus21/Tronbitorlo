var charname = document.getElementsByClassName("mycharname");

var elem = new String();
var fileName = location.pathname.split("/").slice(-1);

class Comment {
    constructor(knev, charimg, beginDate, charmsg)
    {
        this.knev = knev;
        this.charimg = charimg;
        this.beginDate = beginDate;
        this.charmsg = charmsg;
    }
}

var commentList = new Array();



if (typeof(charname) === Array) {
    elem = charname[0].firstChild.textContent;
}
else {
    elem = charname;
}

//console.log(elem);



if(String(fileName) === 'regisztracio.php' ||  String(fileName) === 'karaktermod.php')
{
    var regCharImg = document.getElementById('regCharImg');


    document.getElementById("radioContainer").addEventListener('click', function (event) {
        if (event.target && event.target.matches("input[type='radio']")) {
            var checkedRadio = document.querySelector("input[id*='radio']:checked ~ label");
            regCharImg.src = checkedRadio.firstChild.src;
        }
    });
}

function hideParent(sender) {
    let parent = sender.parentNode;
    parent.style.display = "none";
}

function changeSvgIn() {
    let svg = document.getElementById('exitSvg');
    svg.setAttribute('fill', 'rgb(214, 181, 89)');
}

function changeSvgOut() {
    let svg = document.getElementById('exitSvg');
    svg.setAttribute('fill', '#fff');
}

function getDateDiff(date1, date2) {
    
        let seconds = Math.floor((date1 - (date2))/1000);
        let minutes = Math.floor(seconds/60);
        let hours = Math.floor(minutes/60);
        let days = Math.floor(hours/24);
        
        hours = hours-(days*24);
        minutes = minutes-(days*24*60)-(hours*60);
        seconds = seconds-(days*24*60*60)-(hours*60*60)-(minutes*60);
        
        var TimeDiff = days + '/' + hours + '/' + minutes + '/' + seconds;
        var TimeDiff = TimeDiff.split('/');
        
        var diffTime = '';
        
        for(let i = 0; i < TimeDiff.length; i++)
        {
            switch(i) {
                case 0:
                    var tempString = Number(TimeDiff[i]) === 0 ? '' : Math.abs(TimeDiff[i]) + ' n ';
                    diffTime += tempString;
                    break;
                case 1:
                    var tempString = Number(TimeDiff[i]) === 0 ? '' : Math.abs(TimeDiff[i]) + ' ó ';
                    diffTime += tempString;
                    break;
                case 2:
                    var tempString = Number(TimeDiff[i]) === 0 ? '' : Math.abs(TimeDiff[i]) + ' p ';
                    diffTime += tempString;
                    break;
                case 3:
                    var tempString = Number(TimeDiff[i]) === 0 ? '' : Math.abs(TimeDiff[i]) + ' mp';
                    diffTime += tempString;
                    break;
            }
        }
        
        return diffTime;
        
}

function displayComments (column) {
    let commentContainer = document.getElementsByClassName('comment-container')[0];
    let htmlText = '';
    if(column === 1)
        {
            htmlText += '<h2>Jelenleg a Trónon:</h2>';
        } else 
        {
            htmlText += '<h2>' + column + '. oldal</h2>';
        }
    
    for(let i = column * 10 - 10; i < commentList.length && i < column * 10; i++)
    {
        
        let currentDateTime = new Date();
        let charDateTime = new Date(commentList[i].beginDate);
        
        if( i > 0)
        {
            var prevDateTime = new Date(commentList[i - 1].beginDate);
        }
        
        
//        let trononTime = Math.Abs(getTime(currentDateTime) - getTime(charDateTime)) / 1000;
        let chartime = i === 0 ? getDateDiff(currentDateTime.getTime(), charDateTime.getTime()) : getDateDiff(prevDateTime.getTime(), charDateTime.getTime());
        if (chartime === '')
        {
            chartime = '0 mp';
        }

        let kiegeszites = i === 0 ? ' tronon' : '';
        htmlText += '<div class="comment'+ kiegeszites +'"><img class="img-avatar" src="Images/Avatar/'+commentList[i].charimg+
                '"><a class="knevLink" href="karakter.php?knev='+commentList[i].knev+
                '"><span class="charname">'+commentList[i].knev+'</span></a><span class="chartime">'+chartime+
                '</span><p class="charmsg">'+commentList[i].charmsg+'</p></div>';
    }
    commentContainer.innerHTML = htmlText;
    
    let clickedPageBtn = document.querySelector('.pagination a:nth-child('+column+')');
    let attr = document.createAttribute("class");
    attr.value = 'active';
    clickedPageBtn.setAttributeNode(attr);
    clickedPageBtn.removeAttribute('onclick');
    
    let buttons = document.querySelectorAll('.pagination a');
    
    for (let i = 0; i < buttons.length; i++)
    {
        let button = buttons.item(i);
        if((i + 1) !== column)
        {
            button.removeAttribute('class');
            if(!button.hasAttribute('onclick'))
            {
               let attr = document.createAttribute('onclick');
               attr.value = 'displayComments('+ (i + 1) +')';
               button.setAttributeNode(attr);
            }
        }
    }
}

