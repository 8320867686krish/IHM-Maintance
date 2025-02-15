@if(@$extractSsms)
@foreach ($extractSsms as $value)
<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
    <div class="card" style="background-color: #ebeef2;">
        @if($currentUserRoleLevel == 2 || $currentUserRoleLevel == 3 || $currentUserRoleLevel == 4)
        <a href="{{ route('sms.remove', ['id' => $value['id']]) }}" class="float-right text-right mt-1 mr-1 delete-sms" data-id="{{$value['id']}}">
            <i class="fa fa-trash fa-fw text-danger"></i>
        </a>
        @endif
        <div class="card-body">
            <div class="d-inline-block">
                <h4 class="" style="display: flex;align-items: center;height: 75px;">{{$value['title']}}</h4>
            </div>
            <a href='{{asset("uploads/extractSms/")."/".$value["document"]}}' download="{{$value['document']}}" class="float-right">
                <div class="icon-circle-medium icon-box-lg bg-primary-light mt-1">
                    <i class="fa fa-download fa-fw fa-sm text-primary"></i>
                </div>
            </a>
        </div>
    </div>
</div>
@endforeach
@else
<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
    <div class="card" style="background-color: #ebeef2;">
        <div class="card-body">
            <div class="d-inline-block">
                <h4 class="" style="display: flex;align-items: center;height: 75px;">No Credentials</h4>
            </div>
        </div>
    </div>
</div>
@endif