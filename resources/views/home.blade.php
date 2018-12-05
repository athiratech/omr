@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!<br>Your Role is
                     <?php 
                                   $lastUrl = Session::get("cart");
// echo array_values($lastUrl)[0]; //Value
// print_r($lastUrl);
// print_r($lastUrl[0]);
if($lastUrl){
for($i=0;$i<=sizeof($lastUrl);$i++){

echo $lastUrl[0][$i]->name.' ';

}
}
// echo json_decode($lastUrl);

?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
