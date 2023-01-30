<div class="row justify-content-center mt-5">
  <div class="col-12">
    <div class="card shadow  text-white bg-dark">
      <div class="card-header">Coding Challenge - Network connections</div>
      <div class="card-body">
        <div class="btn-group w-100 mb-3" role="group" aria-label="Basic radio toggle button group">
          <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
          <label class="btn btn-outline-primary" for="btnradio1" id="get_suggestions_btn">Suggestions ({{$networkConnectionCounts['suggestion_count'] ?? 0}})</label>

          <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
          <label class="btn btn-outline-primary" for="btnradio2" id="get_sent_requests_btn">Sent Requests ({{$networkConnectionCounts['sent_request_count'] ?? 0}})</label>

          <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
          <label class="btn btn-outline-primary" for="btnradio3" id="get_received_requests_btn">Received Requests({{$networkConnectionCounts['received_requests_count'] ?? 0}})</label>

          <input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off">
          <label class="btn btn-outline-primary" for="btnradio4" id="get_connections_btn">Connections ({{$networkConnectionCounts['connections_count'] ?? 0}})</label>
        </div>
        <hr>
        <div id="content">
          <div id="content_suggestion">
            <!-- suggestions -->
              @php $loadMoreSuggestion = false @endphp
              @foreach ($suggestionData as $suggestionkey => $suggestion)
                @if ($suggestionkey < 10)
                  <x-suggestion 
                    :id="$suggestion['id']" 
                    :name="$suggestion['name']" 
                    :email="$suggestion['email']"
                  />
                @else
                  @if(!$loadMoreSuggestion)
                    @php $loadMoreSuggestion = true @endphp
                  @endif
                @endif
              @endforeach
              <div id="more_content_suggestion"></div>
              @if($loadMoreSuggestion)
                <div class="d-flex justify-content-center mt-2 py-3 {{-- d-none --}}" id="load_more_btn_parent_suggestion">
                  <button class="btn btn-primary" onclick="getMoreSuggestions()" id="suggestion_load_more_btn">Load more</button>
                </div>
                <input type="hidden" id = "suggestion_limit" value = "10">
              @endif
            <!-- suggestions -->
          </div>

          <div id="content_sr" style="display:none">
            <!-- sent requests -->
              @php $loadMoreSentRequest = false @endphp
              @foreach ($sentRequestData as $srkey => $sr)
                @if ($srkey < 10)
                  <x-request 
                    :id="$sr['id']" 
                    :name="$sr['name']" 
                    :email="$sr['email']"
                    :mode="$sent"
                  />
                @else
                  @if(!$loadMoreSentRequest)
                    @php $loadMoreSentRequest = true @endphp
                  @endif
                @endif
              @endforeach
              <div id="more_content_sr"></div>
              @if($loadMoreSentRequest)
                <div class="d-flex justify-content-center mt-2 py-3 {{-- d-none --}}" id="load_more_btn_parent_sr">
                  <button class="btn btn-primary" onclick="getMoreSentRequests()" id="sr_load_more_btn">Load more</button>
                </div>
                <input type="hidden" id = "sr_limit" value = "10">
              @endif
            <!-- sent requests -->
          </div>

          <div id="content_rr" style="display:none">
            <!-- recieved requests -->
              @php $loadMoreRecievedRequest = false @endphp
              @foreach ($recievedRequestData as $rrkey => $rr)
                @if ($rrkey < 10)
                  <x-request 
                    :id="$rr['id']" 
                    :name="$rr['name']" 
                    :email="$rr['email']"
                    :mode="$recieved"
                  />
                @else
                  @if(!$loadMoreRecievedRequest)
                    @php $loadMoreRecievedRequest = true @endphp
                  @endif
                @endif
              @endforeach
              <div id="more_content_rr"></div>
              @if($loadMoreRecievedRequest)
                <div class="d-flex justify-content-center mt-2 py-3 {{-- d-none --}}" id="load_more_btn_parent_rr">
                  <button class="btn btn-primary" onclick="getMoreRecievedRequests()" id="rr_load_more_btn">Load more</button>
                </div>
                <input type="hidden" id = "rr_limit" value = "10">
              @endif
            <!-- recieved requests -->
          </div>

          <div id="content_connection" style="display:none">
            <!-- connect -->
              @php $loadMoreConnection = false @endphp
              @foreach ($connectionData as $rrkey => $connect)
                @if ($rrkey < 10)
                  <x-connection 
                    :id="$connect['id']" 
                    :name="$connect['name']" 
                    :email="$connect['email']"
                    :common="$connect['common']"
                    :commoncount="count($connect['common'])"
                    :userid="$userid"
                  />
                @else
                  @if(!$loadMoreConnection)
                    @php $loadMoreConnection = true @endphp
                  @endif
                @endif
              @endforeach
              <div id="more_content_connection"></div>
              @if($loadMoreConnection)
                <div class="d-flex justify-content-center mt-2 py-3 {{-- d-none --}}" id="load_more_btn_parent_connection">
                  <button class="btn btn-primary" onclick="getMoreConnections()" id="connection_load_more_btn">Load more</button>
                </div>
                <input type="hidden" id = "connection_limit" value = "10">
              @endif
            <!-- connect -->
          </div>
        <input type="hidden" id = "user_id" value = "{{$userid ?? ''}}">
        </div>
        <div id="skeleton" style="display:none">
          @for ($i = 0; $i < 10; $i++)
            <x-skeleton />
          @endfor
        </div>
      </div>
    </div>
  </div>
</div>