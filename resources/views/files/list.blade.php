@extends('app')
@section('header')
	<style type="text/css">
	    .container {
	      width:1170px;
	      margin:0 auto;
	    }
	  </style>
@endsection
@section('content')
<section class="container" >
	<table class="table">
		<tr>
			<td>ID</td>
			<td>PATH</td>
			<td>FILENAME</td>
			<td>Status</td>
		</tr>
		@foreach ($files as $file)
		<tr>
			<td>{{$file->id}}</td>
			<td>{{$file->path}}</td>
			<td>{{$file->original_filename}}</td>
			<td>Status</td>
		</tr>
		@endforeach
	</table>
</section>
@endsection

@section('script')
@endsection
