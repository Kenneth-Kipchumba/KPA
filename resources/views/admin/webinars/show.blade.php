@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col">
                {{ $webinar->title }}
            </div>
            @can('webinar_create')
            <div class="col">
                <div class="btn-group float-right">
                    <a href="#" class="btn btn-info">Update</a>
                    <form method="POST" action="{{ route('admin.webinars.destroy', $webinar->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are You sure ?')" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
            @endcan
        </div>
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <div class="text-left row">
                    
                    @if($webinar->specialization_id == 22)
                     <div class="col-md-12"  id="pdf-viewer"></div>
                     @else
                 
			 
				 <div class="col-md-12" id="player"></div>
                     @endif 
                </div>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr class="d-none">
                        <th>
                            {{ trans('cruds.webinar.fields.id') }}
                        </th>
                        <td>
                            {{ $webinar->id }}
                        </td>
                    </tr>
                    <tr class="d-none">
                        <th>
                            {{ trans('cruds.webinar.fields.date_time') }}
                        </th>
                        <td>
                            {{ $webinar->date_time }}
                        </td>
                    </tr>
                    <tr class="d-none">
                        <th>
                            {{ trans('cruds.webinar.fields.title') }}
                        </th>
                        <td>
                            {{ $webinar->title }}
                        </td>
                    </tr>
                    <tr class="d-none">
                        <th>
                            {{ trans('cruds.webinar.fields.link') }}
                        </th>
                        <td>
                            {{ $webinar->link }}
                        </td>
                    </tr>
                    <tr class="d-none">
                        <th>
                            {{ trans('cruds.webinar.fields.video') }}
                        </th>
                        <td>
                            {{ $webinar->video }}
                        </td>
                    </tr>
                    <tr >
                        <th>
                            <img width="400" src="{{ $webinar->image->getUrl() }}" />
                      
                        </th>
                        <td>
          
                            {!! $webinar->description !!}
                        </td>
                    </tr>
                    
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.webinars.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
@section('scripts')
<script>

      PDFObject.embed("{{ $webinar->link ?? '' }}", "#pdf-viewer");
      // 2. This code loads the IFrame Player API code asynchronously.
      var tag = document.createElement('script');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      // 3. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.
      var player;
      function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
          height: '390',
          width: '640',
		  controls: 0,
          videoId: '{{ $webinar->video }}',
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
      }

      // 4. The API will call this function when the video player is ready.
      function onPlayerReady(event) {
        event.target.playVideo();
      }

      // 5. The API calls this function when the player's state changes.
      //    The function indicates that when playing a video (state=1),
      //    the player should play for six seconds and then stop.
      var done = false;
      function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING && !done) {
          setTimeout(stopVideo, 6000);
          done = true;
        }
      }
      function stopVideo() {
        player.stopVideo();
      }
    </script>

@endsection