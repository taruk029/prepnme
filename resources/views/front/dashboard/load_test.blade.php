
@foreach($qst as $row)
<input type="hidden" name="question_id" id="question_id" value="{{ $row->id}}">
    @if($row->image_placement==1)
        @if(!empty($row->image_url))
            <?php  $file = base_path().'/public/question_picture/'.$row->image; ?>
            @if(file_exists($file)) 
                <img class="qst_image"  src="{{ $row->image_url }}"><br><br>
            @endif
        @endif
    @endif 

     {{ $row->question }}
    
    @if($row->image_placement==2)
        @if(!empty($row->image_url))
            <?php  $file = base_path().'/public/question_picture/'.$row->image; ?>
            @if(file_exists($file)) 
                <br><br><img class="qst_image" src="{{ $row->image_url }}">
            @endif
        @endif
    @endif 
@endforeach