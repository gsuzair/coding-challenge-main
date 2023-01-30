<div class="my-2 shadow text-white bg-dark p-1" id="connection_{{$id ?? ''}}">
  <div class="d-flex justify-content-between">
    <table class="ms-1">
      <td class="align-middle">{{$name ?? ''}}</td>
      <td class="align-middle"> - </td>
      <td class="align-middle">{{$email ?? ''}}</td>
      <td class="align-middle">
    </table>
    <div>
      <button style="width: 220px" id="get_connections_in_common_{{$id ?? ''}}" class="btn btn-primary" type="button"
        data-bs-toggle="collapse" data-bs-target="#collapse_{{$id ?? ''}}" aria-expanded="false" aria-controls="collapseExample">
        Connections in common ({{count($common) ?? ''}})
      </button>
      <button 
        id="create_request_btn_{{$id ?? ''}}"
        class="btn btn-danger me-1 connection_remove"
        data-id = "{{$id ?? ''}}"
        >Remove Connection</button>
    </div>

  </div>
  <div class="collapse" id="collapse_{{$id ?? ''}}">

    <div id="content_{{$id ?? ''}}" class="p-2 common_content">
      {{-- Display data here --}}
      @foreach($common as $common)
        <x-connection_in_common 
          :name="$common['name']"
          :email="$common['email']"
          :id="$common['id']"
        />
      @endforeach
    </div>
    @if(count($common) > 0)
      <div class="common_skeleton" id="connections_in_common_skeleton_{{$id ?? ''}}" style="display:none">
        <br>
        <span class="fw-bold text-white">Loading Skeletons</span>
        <div class="px-2">
          @for ($i = 0; $i < 10; $i++)
            <x-skeleton />
          @endfor
        </div>
      </div>
      <div id="connections_in_common_skeletons_{{$id ?? ''}}">
        {{-- Paste the loading skeletons here via Jquery before the ajax to get the connections in common --}}
      </div>
      <div class="d-flex justify-content-center w-100 py-2">
        <button 
          class="btn btn-sm btn-primary common_connection_load_more_btn" 
          id="load_more_connections_in_common_{{$id ?? ''}}"
          onclick=getMoreConnectionsInCommon({{$id}})
        >Load more</button>
      </div>
    @endif
    <input type="hidden" id = "connection_in_common_limit_{{$id ?? ''}}" value = "10">
  </div>
</div>
