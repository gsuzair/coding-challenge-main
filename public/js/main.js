var skeletonId = 'skeleton';
var contentId = 'content';
var skipCounter = 0;
var takeAmount = 10;


function getRequests(mode) {
  // your code here...
}

function getMoreRequests(mode) {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...
}

function getMoreSentRequests() {
  $('#content').hide()
  $('#skeleton').show()
  var sr_limit = $('#sr_limit').val();
  sr_limit = parseInt(sr_limit)

  var form = ajaxForm([
    ['sr_limit', sr_limit],
  ]);


  setTimeout(() => { 
    ajax('/requests/sent/load_more', 'POST', form, 'sent_requests');
  }, 500);
  sr_limit = sr_limit + 10
  $('#sr_limit').val(sr_limit);
}

function getMoreRecievedRequests() {
  $('#content').hide()
  $('#skeleton').show()
  var rr_limit = $('#rr_limit').val();
  rr_limit = parseInt(rr_limit)

  var form = ajaxForm([
    ['rr_limit', rr_limit],
  ]);


  setTimeout(() => { 
    ajax('/requests/recieved/load_more', 'POST', form, 'recieved_requests');
  }, 500);
  rr_limit = rr_limit + 10
  $('#rr_limit').val(rr_limit);
}

function getConnections() {
  
}

function getMoreConnections() {
  $('#content').hide()
  $('#skeleton').show()
  var connection_limit = $('#connection_limit').val();
  connection_limit = parseInt(connection_limit)

  var form = ajaxForm([
    ['connection_limit', connection_limit],
  ]);


  setTimeout(() => { 
    ajax('/connections/load_more', 'POST', form, 'connections');
  }, 500);
  connection_limit = connection_limit + 10
  $('#connection_limit').val(connection_limit);
}

function getConnectionsInCommon(userId, connectionId) {
  // your code here...
}

function getMoreConnectionsInCommon(connectionId) {
  $('#content_'+connectionId).hide()
  $('#connections_in_common_skeleton_'+connectionId).show()
  var connection_in_common_limit = $('#connection_in_common_limit_'+connectionId).val();
  connection_in_common_limit = parseInt(connection_in_common_limit)

  var form = ajaxForm([
    ['connection_in_common_limit', connection_in_common_limit],
    ['id', connectionId],
  ]);


  setTimeout(() => { 
    ajax('/connections/common/load_more', 'POST', form, 'connections_common');
  }, 500);
  connection_in_common_limit = connection_in_common_limit + 10
  $('#connection_in_common_limit_'+connectionId).val(connection_in_common_limit);
}

function getSuggestions() {
  // your code here...
}

function getMoreSuggestions() {
  $('#content').hide()
  $('#skeleton').show()
  var suggestion_limit = $('#suggestion_limit').val();
  suggestion_limit = parseInt(suggestion_limit)

  var form = ajaxForm([
    ['suggestion_limit', suggestion_limit],
  ]);


  setTimeout(() => { 
    ajax('/suggestions/load_more', 'POST', form, 'suggestions');
  }, 500);
  suggestion_limit = suggestion_limit + 10
  $('#suggestion_limit').val(suggestion_limit);
}

function sendRequest(userId, suggestionId) {
  // your code here...
}

function deleteRequest(userId, requestId) {
  // your code here...
}

function acceptRequest(userId, requestId) {
  // your code here...
}

function removeConnection(userId, connectionId) {
  // your code here...
}



$(function () {

});



$('#btnradio1').on('click',function(){
  $("#content_suggestion").show()
  $("#content_sr").hide()
  $("#content_rr").hide()
  $("#content_connection").hide()
});

$('#btnradio2').on('click',function(){
  $("#content_suggestion").hide()
  $("#content_sr").show()
  $("#content_rr").hide()
  $("#content_connection").hide()
});

$('#btnradio3').on('click',function(){
  $("#content_suggestion").hide()
  $("#content_sr").hide()
  $("#content_rr").show()
  $("#content_connection").hide()
});

$('#btnradio4').on('click',function(){
  $("#content_suggestion").hide()
  $("#content_sr").hide()
  $("#content_rr").hide()
  $("#content_connection").show()
});

$('body').on('click', '.suggestion_connect', function() {
  var form = ajaxForm([
    ['id', $( this ).data('id')],
  ]);

  ajax('/suggestions/connect', 'POST', form, 'suggestions');
});

$('body').on('click', '.sr_cancel', function() {
  var form = ajaxForm([
    ['id', $( this ).data('id')],
  ]);

  ajax('requests/sent/cancel', 'POST', form, 'sent_requests');
});

$('body').on('click', '.rr_accept', function() {
  var form = ajaxForm([
    ['id', $( this ).data('id')],
  ]);

  ajax('requests/recieved/accept', 'POST', form, 'recieved_requests');
});

$('body').on('click', '.connection_remove', function() {
  var form = ajaxForm([
    ['id', $( this ).data('id')],
  ]);

  ajax('connections/remove', 'POST', form, 'connections');
});

function suggestionLoadMoreData(data)
{
  $('#skeleton').hide()
  $('#content').show()
  var html = '';
  html += '<div class="my-2 shadow  text-white bg-dark p-1" id="suggestion-'+data.id+'">\
    <div class="d-flex justify-content-between">\
      <table class="ms-1">\
        <td class="align-middle">'+data.name+'<td>\
        <td class="align-middle"> - </td>\
        <td class="align-middle">'+data.email+'</td>\
        <td class="align-middle"> \
      </table>\
      <div>\
        <button \
          id="create_request_btn_" \
          class="btn btn-primary me-1 suggestion_connect"\
          data-id = "'+data.id+'"\
          >Connect</button>\
      </div>\
    </div>\
  </div>';
  $('#more_content_suggestion').append(html);
}

function sentRequestsLoadMoreData(data)
{
  $('#skeleton').hide()
  $('#content').show()
  var html = '';
  html += '<div class="my-2 shadow text-white bg-dark p-1" id="sr_'+data.id+'">\
    <div class="d-flex justify-content-between">\
      <table class="ms-1">\
        <td class="align-middle">'+data.name+'<td>\
        <td class="align-middle"> - </td>\
        <td class="align-middle">'+data.email+'</td>\
        <td class="align-middle"> \
      </table>\
      <div>\
        <button \
          id="cancel_request_btn_" \
          class="btn btn-danger me-1 sr_cancel"\
          data-id = "'+data.id+'"\
          >Withdraw Request</button>\
      </div>\
    </div>\
  </div>';
  $('#more_content_sr').append(html);
}

function recievedRequestsLoadMoreData(data)
{
  $('#skeleton').hide()
  $('#content').show()
  var html = '';
  html += '<div class="my-2 shadow text-white bg-dark p-1" id="rr_'+data.id+'">\
    <div class="d-flex justify-content-between">\
      <table class="ms-1">\
        <td class="align-middle">'+data.name+'<td>\
        <td class="align-middle"> - </td>\
        <td class="align-middle">'+data.email+'</td>\
        <td class="align-middle"> \
      </table>\
      <div>\
        <button \
          id="accept_request_btn_" \
          class="btn btn-primary me-1 rr_accept"\
          data-id = "'+data.id+'"\
          >Accept</button>\
      </div>\
    </div>\
  </div>';
  $('#more_content_rr').append(html);
}

function connectionsLoadMoreData(data)
{
  $('#skeleton').hide()
  $('#content').show()
  var html = '';
  html += '<div class="my-2 shadow text-white bg-dark p-1" id="connection_'+data.id+'">\
  <div class="d-flex justify-content-between">\
    <table class="ms-1">\
      <td class="align-middle">'+data.name+'</td>\
      <td class="align-middle"> - </td>\
      <td class="align-middle">'+data.email+'</td>\
      <td class="align-middle">\
    </table>\
    <div>\
      <button style="width: 220px" id="get_connections_in_common_'+data.id+'" class="btn btn-primary" type="button"\
        data-bs-toggle="collapse" data-bs-target="#collapse_'+data.id+'" aria-expanded="false" aria-controls="collapseExample">\
        Connections in common ('+data.common.length+')\
      </button>\
      <button \
        id="create_request_btn_"\
        class="btn btn-danger me-1 connection_remove"\
        data-id = "'+data.id+'"\
        >Remove Connection</button>\
    </div>\
  </div>\
  <div class="collapse" id="collapse_'+data.id+'">\
    <div id="content_" class="p-2">\
      <x-connection_in_common />\
    </div>\
    <div id="connections_in_common_skeletons_">\
    </div>\
    <div class="d-flex justify-content-center w-100 py-2">\
      <button class="btn btn-sm btn-primary" id="load_more_connections_in_common_">Load\
        more</button>\
    </div>\
  </div>\
</div>';

  $('#more_content_connection').append(html);
}

function connectionsCommonLoadMoreData(data)
{
  console.log(data)
  $('#connections_in_common_skeleton_'+data.id).hide()
  $('#content_'+data.id).show()
  var html = '';
  html += '<div class="p-2 shadow rounded mt-2  text-white bg-dark">'+data.name+' - '+data.email+'</div>';

  $('#connections_in_common_data_'+data.id).append(html);
}