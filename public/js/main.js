var montant = document.querySelector(".montant");


    function OnClickShow() 
    {
        fetch("{{ path('amount_donate_new',{'id':donneur.id}) }}")
    .then(function (response) {
        return response.json();
    })
    .then(function (data) {
        var p = document.createElement('<p>')
        montant.appendChild(p);
       // console.log(data);
                    var p = $('<h4>').html('Voici ton mail :'+data.mail);
                    montant.append(p);
                    var ul = $('<ul>');
                     montant.append(ul);                  
                        
                    // for(var mail of data)
                    // {    
                    //     var li = $('<li>');
                    //     ul.append(li);
                    // var a = $('<a>');
                    //     li.append(a);
                    //     a.html(mail.email).attr('href', mail.href);
                    //     console.log(mail.email)
                    // } 

    })
       
        }
    $(".continue").on("click", OnClickShow);