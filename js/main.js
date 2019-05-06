$(document).ready(function(){
	
	var requestList = $.ajax({
		method:'GET',
		url:'post.php',
		data:{listAll:"list"},
		dataType:'json'
	});

	requestList.done(function(e){
		
		var table = '<thead><tr><th>#</th><th>Name</th><th>Email</th><th>Telephone</th></tr></thead><tbody>';
		for(k in e){
			table += '<tr><th scope="row">'+ e[k].id +'</th>';
			table += '<td>'+ e[k].name +'</td>';
			table += '<td>'+ e[k].email +'</td>';
			table += '<td>'+ e[k].tel +'</td></tr>';
		}
		table += '</tbody>';
		$('#contacts').html(table);
	});


	$("#ajaxRequest").submit(function(){
		var form = $(this).serialize();
		var request = $.ajax({
			method:"POST",
			url:"post.php",
			data: form,
			dataType: "json"
		});

		request.done(function(e){    // DONE entrará nessa function toda vez que a requisição ocorrer com sucesso
			$('#msg').html(e.msg);

			if (e.status) {
				$('#ajaxRequest').each(function(){
					this.reset();
				});

				var table = '<tr><th scope="row">'+ e.contacts.id +'</th>';
				table += '<td>'+ e.contacts.name +'</td>';
				table += '<td>'+ e.contacts.email +'</td>';
				table += '<td>'+ e.contacts.tel +'</td></tr>';
				$('#contacts tbody').prepend(table); //COLOCA O NOVO REGISTRO EM PRIMEIRO
			}


			//for(var k in e){
			//	$(':input[name='+k+']').val(e[k]);
			//}
		});

		request.fail(function(e){    // FAIL entrará nessa function toda vez que a requisição der error
			console.log(e);
		});

		request.always(function(e){    // ALWAYS serve para ficar escutando a resposta da requisição
			console.log(e);
		});

		//retornando false ele não atualiza a página
		return false;
	});
});