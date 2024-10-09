@extends('layouts.app')
@section('content')
    <div class="container-fluid dashboard-content">
        <!-- ============================================================== -->
        <!-- pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Dashboard</h2>
                    <h3 style="color:#6c757d;font-size:14px;">Welcom {{Auth()->user()->name}} everything looks great.</h3>
                </div>
            </div>
        </div>
    </div>
    @stop
