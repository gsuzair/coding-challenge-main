function ajaxForm(formItems) {
  var form = new FormData();
  formItems.forEach(formItem => {
    form.append(formItem[0], formItem[1]);
  });
  return form;
}



/**
 * 
 * @param {*} url route
 * @param {*} method POST or GET 
 * @param {*} functionsOnSuccess Array of functions that should be called after ajax
 * @param {*} form for POST request
 */
function ajax(url, method, form, loadType = '') {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  })

  if (typeof form === 'undefined') {
    form = new FormData;
  }

  // if (typeof functionsOnSuccess === 'undefined') {
  //   functionsOnSuccess = [];
  // }

  $.ajax({
    url: url,
    type: method,
    async: true,
    data: form,
    processData: false,
    contentType: false,
    dataType: 'json',
    error: function(xhr, textStatus, error) {
      console.log(xhr.responseText);
      console.log(xhr.statusText);
      console.log(textStatus);
      console.log(error);
    },
    success: function(response) {
      if(response.status)
      {
        console.log(form.get('id'));
        if(loadType == 'suggestions')
        {
          $('#suggestion_'+form.get('id')).remove()
        }
        else if(loadType == 'sent_requests')
        {
          $('#sr_'+form.get('id')).remove()
        }
        else if(loadType == 'recieved_requests')
        {
          $('#rr_'+form.get('id')).remove()
        }
        else if(loadType == 'connections')
        {
          $('#connection_'+form.get('id')).remove()
        }
      }
      else 
      {

        if(loadType == 'suggestions')
        {
          if(response.length < 1)
          {
            $("#suggestion_load_more_btn").remove()
            $('#skeleton').hide()
            $('#content').show()
          }
          else 
          {
            for(var i = 0; i < response.length; i++)
            {
              suggestionLoadMoreData(response[i])
            }
          }
        }
        else if(loadType == 'sent_requests')
        {
          if(response.length < 1)
          {
            $("#sr_load_more_btn").remove()
            $('#skeleton').hide()
            $('#content').show()
          }
          else 
          {
            for(var i = 0; i < response.length; i++)
            {
              sentRequestsLoadMoreData(response[i]);
            }
          }
        }
        else if(loadType == 'recieved_requests')
        {
          if(response.length < 1)
          {
            $("#rr_load_more_btn").remove()
            $('#skeleton').hide()
            $('#content').show()
          }
          else 
          {
            for(var i = 0; i < response.length; i++)
            {
              recievedRequestsLoadMoreData(response[i]);
            }
          }
        }
        else if(loadType == 'connections')
        {
          if(response.length < 1)
          {
            $("#connection_load_more_btn").remove()
            $('#skeleton').hide()
            $('#content').show()
          }
          else 
          {
            for(var i = 0; i < response.length; i++)
            {
              connectionsLoadMoreData(response[i]);
            }
          }
        }
        else if(loadType == 'connections_common')
        {
          console.log(response)
          if(response.length < 1)
          {
            $(".common_connection_load_more_btn").remove()
            $('.common_skeleton').hide()
            $('.common_content').show()
          }
          else 
          {
            for(var i = 0; i < response.length; i++)
            {
              connectionsCommonLoadMoreData(response[i]);
            }
          }
        }
      }
      
    }
  });
}


function exampleUseOfAjaxFunction(exampleVariable) {
  // show skeletons
  // hide content

  var form = ajaxForm([
    ['exampleVariable', exampleVariable],
  ]);

  var functionsOnSuccess = [
    [exampleOnSuccessFunction, [exampleVariable, 'response']]
  ];

  // POST 
  ajax('/example_route', 'POST', functionsOnSuccess, form);

  // GET
  ajax('/example_route/' + exampleVariable, 'POST', functionsOnSuccess);
}

function exampleOnSuccessFunction(exampleVariable, response) {
  // hide skeletons
  // show content

  console.log(exampleVariable);
  console.table(response);
  $('#content').html(response['content']);
}

