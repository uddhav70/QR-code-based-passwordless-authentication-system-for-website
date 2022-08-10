$(document).ready(function(){
	$('.signupbtn').click(function() {
		if($('.sign-up input').val() == '' && $('.sign-up input').val() == null) {
			alert('Please fill all the fields.');
		}	
	});
	$('input[name=reg_username], input[name=username]').keyup(function() {
		var username = $(this).val();
		if(username != "") {
			$('.qrcode > p').text('Please scan this code').css("color","#fff");
            var num = getRandomInt(1000, 9999);
            username = btoa(num+"_"+username);
			$('.qrcode > img').attr('src','http://chart.apis.google.com/chart?chs=180x180&cht=qr&chl='+username+'&choe=ISO-8859-1');
		}else {
			$('.qrcode > p').text('');
			$('.qrcode > img').attr('src','');
		}
	});
});
$(document).ready(function() {

    $('.resetbtn').click(function() {
        var mobile = prompt('Mobile number');
        $.ajax({
            url: 'php/functions.php',
            method:'GET',
            data: {action:'resetphone',mobile:mobile},
            success: function(username) {
                if(username == '') {
                    alert('No match found!');
                    return false;
                }
                username = JSON.parse(username);
                // console.log(username);
                var otp = prompt('OTP');
                if(otp == username.OTP) {
                    $('.qrcode > p').text('Please scan this code').css("color","#fff");
                    var num = getRandomInt(1000, 9999);
                    var email = btoa(num+"_"+username.email);
                    $('.qrcode > img').attr('src','http://chart.apis.google.com/chart?chs=180x180&cht=qr&chl='+email+'&choe=ISO-8859-1');
                    var interval = setInterval(function() {
                      $.ajax({
                        url: "php/functions.php",
                        data: {action:'getsession'},
                        success: function(resp){
                            // console.log(resp);
                          resp = JSON.parse(resp);
                          var otp = resp["OTP"];
                          var email = resp["email"];
                          if(otp != '' && email != '' && resp["resetphone"] == 1) {
                            alert(resp['error_message']);
                            clearInterval(interval);
                            window.location.reload();
                          }
                          if(count > 500) {
                            clearInterval(interval);
                            window.location.reload();
                            count = 0;
                          }
                        }
                      });
                    },1000);
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
    $('#view-files-user').click(function() {
        $('ul li a').css("text-decoration","none");
        $('ul li a').css("color","#fff");
        $(this).css("text-decoration","underline");
        $(this).css("color","black");
        $.ajax({
            url: 'files.php',
            method:'post',
            data: {getfile:1},
            success: function(response) {
                $('#display-content').html('');
                console.log(response);
                if(response != '' && response != 'Invalid request.' && response != 'No result found') {
                    response = JSON.parse(response);
                    $('#display-content').append('<table><tr><th>Name</th><th>Type</th><th>Size</th><th>Download</th></tr></table>');
                    $.each(response,function(index,value) {
                        $('#display-content table').append('<tr><td>'+value["name"]+'</td><td>'+value["type"]+'</td><td>'+value["size"]+' Byte</td><td><input type = "button" name = "download" data="'+index+'" value = "Download" /></td></tr>');
                    });     
                }else{
                    $('#display-content').append('<table><tr><b>'+response+'</b></tr></table>');
                    console.log(response);  
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
    $(document).on('click','input[name=download]',function() {
        var id= $(this).attr('data');
        var url = "../php/download_files.php?fileid="+id;
        window.open(url, '_blank');
    });
 
    $('#about').click(function() {
        $('ul li a').css("text-decoration","none");
        $('ul li a').css("color","#fff");
        $(this).css("text-decoration","underline");
        $(this).css("color","black");
        $('#display-content').html("<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><br><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><br><p>Lorem ipsum dolor sit amet, ornatus facilisi eu eam, eum no inermis appetere. Usu sanctus atomorum petentium eu, eos ei errem saperet tibique. Per ut sale ullamcorper, habeo referrentur in pro, justo dicta at mea. Vim at alienum voluptaria, ex fabellas suavitate definitiones vix, ne mei tation ignota. Est ad principes dissentiet, odio saperet accusam qui at. Eum solet aperiam inermis ne.Falli molestie similique et est. Rebum dolore libris cu vel, option nusquam ex sit. Sea luptatum dissentiet at, tota latine accusam cum an, ne ius adhuc simul suscipiantur. Cu eam everti discere splendide, cum nibh wisi an, ut his graeci putant. Posse tantas nec id, eum latine appellantur ad.An eam rebum evertitur, inani possit te has. Sit cu fuisset ullamcorper, vel feugait nusquam consectetuer id, ad quas malis mei. Eos lorem suscipiantur ex, mei melius veritus ne. Has ut ignota vivendum, at gubergren euripidis vim. No per tibique cotidieque.Ex tamquam signiferumque vis, ad nec aperiri virtute theophrastus. Sea partem ignota ex, ea idque malorum sea, mei id sanctus offendit. Alii natum his id. Apeirian invenire at his, ei duo dicunt fierent, id nec tempor admodum reformidans. Te meis doming scriptorem has. Harum omnesque vel ea, pri movet choro id. At mei erat ancillae, delenit eloquentiam ius ne, usu quodsi copiosae at.Omnium eruditi repudiare ius ne, stet complectitur pro ea. Ut liber causae suscipiantur sed. His ne augue senserit. Usu ne meliore facilisis consetetur, pro cu facer percipitur. Animal conceptam reformidans quo cu. Errem tantas sed cu.</p>");
    });
});
function createCookie(name, value, days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    }
    else var expires = "";               

    document.cookie = name + "=" + value + expires + "; path=/";
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name, "", -1);
}

function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}