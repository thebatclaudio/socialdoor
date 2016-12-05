$(document).ready(function(){
	//ajax function for post submit
	$("#submit-post").click(function(){
		$(this).addClass("disabled");
        $.ajax({
                type: 'post',
                url: 'submitPost',
                data: "content="+$("#textarea-post").val(),
                contentType: "application/x-www-form-urlencoded;charset=utf-8",
                success: function(data) {
                	if(data.status == "KO"){
                		$("#submit-post").removeClass("btn-socialdoor").addClass("btn-danger");
                		$("#submit-post").html("Ops! There was an error!");
                	} else {
                		var img = "";
                		if(data.response.pic == 1){
                			img = "<a href='room/"+data.response.userID+"' class='pull-left'><img src='photos/"+data.response.userID+".jpg' class='media-object' ></a>";
                		} else {
                			img = "<a href='room/"+data.response.userID+"' class='pull-left'><img src='img/profile_photo.png' class='media-object' ></a>";         			
                		}
	                	var text = '<div class="row posts-row">'
		                  +'<div class="col-lg-8 col-md-offset-2 socialdoor-">'
		                      +'<div class="media">'
		                          +img
		                          +'<div class="media-body">'
		                            +'<h4 class="media-heading"><a href="'+data.response.userID+'">'+data.response.userName+'</a> writes</h4>'
		                            +'<div class="well socialdoor-well">'
		                              +data.response.content
		                            +'</div>'
		                            +'<div class="pull-right post-footer">'
		                                +data.response.postDate+' - <a href="post/'+data.response.postID+'">Comment</a>'
		                            +'</div>'
		                          +'</div>'
		                      +'</div>'
		                  +'</div>'
		              +'</div>';
		              $("#last-posts-container").prepend(text);
		              $("#textarea-post").val("");
				      $("#submit-post").removeClass("disabled");
			      }
                }
        });
	});
	
	//ajax function for comment submit
	$("#submit-comment").click(function(){
		$(this).addClass("disabled");
		$.ajax({
                type: 'post',
                url: '../comment',
                data: "content="+$("#textarea-comment").val()+"&idPost="+$("#post-id").val(),
                contentType: "application/x-www-form-urlencoded;charset=utf-8",
                success: function(data) {
                	if(data.status == "KO"){
                		$("#submit-comment").removeClass("btn-socialdoor").addClass("btn-danger");
                		$("#submit-comment").html("Ops! There was an error!");
                	} else {
                		var img = "";
                		if(data.response.pic == 1){
                			img = "<a href='room/"+data.response.userID+"'><img src='../photos/"+data.response.userID+".jpg' class='media-object' ></a>";
                		} else {
                			img = "<a href='room/"+data.response.userID+"'><img src='../img/profile_photo.png' class='media-object' ></a>";         			
                		}
	                	var text = '<div class="media">'
		                          +'<span class="pull-left">'+img+'</span>'
		                          +'<div class="media-body">'
		                            +'<h4 class="media-heading"><a href="'+data.response.userID+'">'+data.response.userName+'</a>:</h4>'
		                            +'<div class="well socialdoor-well">'
		                              +data.response.content
		                            +'</div>'
		                            +'<div class="pull-right post-footer">'
		                                +data.response.commentDate
		                            +'</div>'
		                          +'</div>'
		                      +'</div>';
		              $("#post-body").append(text);
		              $("#textarea-comment").val("");
				      $("#submit-comment").removeClass("disabled");
			      }
                }
        });
	})
});
