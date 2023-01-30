<div class="my-2 shadow  text-white bg-dark p-1" id="suggestion_{{$id ?? ''}}">
  <div class="d-flex justify-content-between">
    <table class="ms-1">
      <td class="align-middle">{{$name ?? ''}}</td>
      <td class="align-middle"> - </td>
      <td class="align-middle">{{$email ?? ''}}</td>
      <td class="align-middle"> 
    </table>
    <div>
      <button 
        id="create_request_btn_" 
        class="btn btn-primary me-1 suggestion_connect"
        data-id = "{{$id ?? ''}}"
        >Connect</button>
    </div>
  </div>
</div>
