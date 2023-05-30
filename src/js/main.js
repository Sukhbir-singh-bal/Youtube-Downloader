$(document).ready(function () {
    $("#result").hide();
    $(".errorbox").hide();
});
function fetchUrls(){
    $("#result").hide();
    $("#links").html(" ");
    $(".errorbox").hide();
    event.preventDefault();
    let url = $("#Urltext").val();
    $.ajax({
        type: "Post",
        url: "/includes/youtube.php",
        data: "Url="+url,
        success: function (response) {
            let result = JSON.parse(response);
            if(result.hasOwnProperty('error')){
                    $("#error").text(result.error);
                    $(".errorbox").show();
            }else{
                let Videoinfo = result[0];
                let Videolinks = result[1];
                $("#thumbnil").attr("src",Videoinfo[0].thumbnail);
                $("#title").text(Videoinfo[0].title);
                $("#duration").text(Videoinfo[0].duration);
                Videolinks.forEach(function(data){
                    let type = "mp4";
                    let url = "";
                    if(data.cipher == true){
                        let signature  = data.signature;
                        let decryptcode = decryptfunc(signature);
                        url = data.url+"&sig="+decryptcode;
                    }else{
                        url = data.url;
                    }
                    if(data.format.includes("audio")){
                        type = "mp3"
                    }
                    if(data.audio == true){
                        $("#links").append('<div class="row justify-content-between p-2 border"><h6>'+data.format+'</h6> <form action="/includes/youtubeDownloader.php" method="get"><input type="hidden" name="type" value="'+type+'"><input type="hidden" name="title" value="'+Videoinfo[0].title+'"><input type="hidden" name="url" value="'+url+'"><button type="submit" class="btn btn-light px-2 py-0 text-primary Videolink"><i class="fas fa-download px-2"></i>Download '+data.quality+'</button><a href="'+url+'"><i class="fa-solid fa-eye px-1"></i></a></form></div>')
                    }else{
                        $("#links").append('<div class="row justify-content-between p-2 border"><h6>'+data.format+'<i class="fa-solid fa-volume-xmark pl-2 text-danger"></i></h6> <form action="/includes/youtubeDownloader.php" method="get"><input type="hidden" name="type" value="mp4"><input type="hidden" name="title" value="'+Videoinfo[0].title+'"><input type="hidden" name="url" value="'+url+'"><button type="submit" class="btn btn-light px-2 py-0 text-primary Videolink"><i class="fas fa-download px-2"></i>Download '+data.quality+'</button><a href="'+url+'"><i class="fa-solid fa-eye px-1"></i></a></form></div>')
                    }
                    
                });
                $("#result").slideDown(1000);
            }
            
        }
    });
}