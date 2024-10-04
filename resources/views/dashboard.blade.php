@extends('Layout.master')
@section('main_section')
    <!-- start page title -->
    <div class="row">
        <div class="col-12 mb-2">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h3 class="mb-sm-0 fw-semibold font-size-18">Dashboard</h3>
                <div>
                    @if ($attendance)
                        <a class="btn btn-primary attend-btn {{ $attendance->check_in == null && $attendance->check_out == null ? '' : 'disabled' }}"
                            href="{{ route('check.in') }}">Check In</a>
                        <a class="btn btn-primary attend-btn {{ $attendance->check_in != null && $attendance->check_out == null ? '' : 'disabled' }}"
                            href="{{ route('check.out') }}">Check Out</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        {{-- <div class="col-xl-4">
            <div class="card overflow-hidden">
                <div class="bg-primary-subtle">
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary p-3">
                                <h5 class="text-primary">Welcome Back !</h5>
                                <p>{{ auth()->user()->role->name ?? '' }} Dashboard</p>
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
                            <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="avatar-md profile-user-wid mb-4">
                                <img src="assets/images/users/avatar-1.jpg" alt=""
                                    class="img-thumbnail rounded-circle">
                            </div>
                            <h5 class="font-size-15 text-truncate">Henry Price</h5>
                            <p class="text-muted mb-0 text-truncate">UI/UX Designer</p>
                        </div>

                        <div class="col-sm-8">
                            <div class="pt-4">

                                <div class="row">
                                    <div class="col-6">
                                        <h5 class="font-size-15">125</h5>
                                        <p class="text-muted mb-0">Projects</p>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="font-size-15">$1245</h5>
                                        <p class="text-muted mb-0">Revenue</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="javascript: void(0);"
                                        class="btn btn-primary waves-effect waves-light btn-sm">View
                                        Profile <i class="mdi mdi-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div> --}}
        <!--<div class="col-xl-8">-->
        <!--    <div class="row">-->
        <!--        <div class="col-md-4">-->
        <!--            <div class="card mini-stats-wid">-->
        <!--                <div class="card-body">-->
        <!--                    <div class="d-flex">-->
        <!--                        <div class="flex-grow-1">-->
        <!--                            <p class="text-muted fw-medium">Orders</p>-->
        <!--                            <h4 class="mb-2">1,235</h4>-->
        <!--                        </div>-->
        <!--                        <div class="flex-shrink-0 align-self-center">-->
        <!--                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">-->
        <!--                                <span class="avatar-title">-->
        <!--                                    <i class="bx bx-copy-alt font-size-24"></i>-->
        <!--                                </span>-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--        <div class="col-md-4">-->
        <!--            <div class="card mini-stats-wid">-->
        <!--                <div class="card-body">-->
        <!--                    <div class="d-flex">-->
        <!--                        <div class="flex-grow-1">-->
        <!--                            <p class="text-muted fw-medium">Revenue</p>-->
        <!--                            <h4 class="mb-2">$35, 723</h4>-->
        <!--                        </div>-->

        <!--                        <div class="flex-shrink-0 align-self-center ">-->
        <!--                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">-->
        <!--                                <span class="avatar-title rounded-circle bg-primary">-->
        <!--                                    <i class="bx bx-archive-in font-size-24"></i>-->
        <!--                                </span>-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--        <div class="col-md-4">-->
        <!--            <div class="card mini-stats-wid">-->
        <!--                <div class="card-body">-->
        <!--                    <div class="d-flex">-->
        <!--                        <div class="flex-grow-1">-->
        <!--                            <p class="text-muted fw-medium">Average Price</p>-->
        <!--                            <h4 class="mb-2">$16.2</h4>-->
        <!--                        </div>-->

        <!--                        <div class="flex-shrink-0 align-self-center">-->
        <!--                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">-->
        <!--                                <span class="avatar-title rounded-circle bg-primary">-->
        <!--                                    <i class="bx bx-purchase-tag-alt font-size-24"></i>-->
        <!--                                </span>-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--        <div class="col-md-4">-->
        <!--            <div class="card mini-stats-wid">-->
        <!--                <div class="card-body">-->
        <!--                    <div class="d-flex">-->
        <!--                        <div class="flex-grow-1">-->
        <!--                            <p class="text-muted fw-medium">Orders</p>-->
        <!--                            <h4 class="mb-2">1,235</h4>-->
        <!--                        </div>-->

        <!--                        <div class="flex-shrink-0 align-self-center">-->
        <!--                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">-->
        <!--                                <span class="avatar-title">-->
        <!--                                    <i class="bx bx-copy-alt font-size-24"></i>-->
        <!--                                </span>-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--        <div class="col-md-4">-->
        <!--            <div class="card mini-stats-wid">-->
        <!--                <div class="card-body">-->
        <!--                    <div class="d-flex">-->
        <!--                        <div class="flex-grow-1">-->
        <!--                            <p class="text-muted fw-medium">Revenue</p>-->
        <!--                            <h4 class="mb-2">$35, 723</h4>-->
        <!--                        </div>-->

        <!--                        <div class="flex-shrink-0 align-self-center ">-->
        <!--                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">-->
        <!--                                <span class="avatar-title rounded-circle bg-primary">-->
        <!--                                    <i class="bx bx-archive-in font-size-24"></i>-->
        <!--                                </span>-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--        <div class="col-md-4">-->
        <!--            <div class="card mini-stats-wid">-->
        <!--                <div class="card-body">-->
        <!--                    <div class="d-flex">-->
        <!--                        <div class="flex-grow-1">-->
        <!--                            <p class="text-muted fw-medium">Average Price</p>-->
        <!--                            <h4 class="mb-2">$16.2</h4>-->
        <!--                        </div>-->
        <!--                        <div class="flex-shrink-0 align-self-center">-->
        <!--                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">-->
        <!--                                <span class="avatar-title rounded-circle bg-primary">-->
        <!--                                    <i class="bx bx-purchase-tag-alt font-size-24"></i>-->
        <!--                                </span>-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
    </div>
    @if (count($notices) > 0)
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Notice Board</h4>
                    <hr>
                    <br>
                    <div data-simplebar="init" style="min-height: 90px !important; max-height:340px"
                        class="simplebar-scrollable-y">
                        <div class="simplebar-wrapper" style="margin: 0px;">
                            <div class="simplebar-height-auto-observer-wrapper">
                                <div class="simplebar-height-auto-observer"></div>
                            </div>
                            <div class="simplebar-mask">
                                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                    <div class="simplebar-content-wrapper" tabindex="0" role="region"
                                        aria-label="scrollable content" style="height: auto; overflow: hidden scroll;">
                                        <div class="simplebar-content" style="padding: 0px;">
                                            <div class="vstack d-flex align-items-start ">
                                                @foreach ($notices as $notice)
                                                    <div class="d-flex mb-3">
                                                        <span
                                                            class="{{ $notice->status }} font-size-14 fw-semibold d-flex justify-content-center align-items-center rounded-3">
                                                            <p class="pt-3">
                                                                {{ \Carbon\Carbon::parse($notice->date)->format('d M') }}
                                                            </p>
                                                        </span>
                                                        <div class="ms-2 flex-grow-1 mt-1">
                                                            <h6 class="mb-1 font-size-15 mt-1"><a href="job-details.html"
                                                                    class="text-body">{{ $notice->title }}</a></h6>
                                                            <p class="text-muted mb-0">
                                                                {{ Str::words($notice->description, 5, '..') }}. <a
                                                                    href="#" class="view-more-link view-more"
                                                                    data-id="{{ $notice->id }}">View
                                                                    more</a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="simplebar-placeholder" style="width: 372px; height: 520px;"></div>
                        </div>
                        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                            <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                        </div>
                        <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                            <div class="simplebar-scrollbar"
                                style="height: 271px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                        </div>
                    </div>
                </div>
            </div><!--end card-->
        </div>
    @endif

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Notice</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="description-box">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.view-more').click(function() {
                var id = $(this).data('id');
                var url = "{{ route('get.notice.board.data') }}";
                $.ajax({
                    url: url,
                    method: "GET",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        console.log(response);
                        $('#description-box').html(response.description);
                        $('#exampleModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
    <script>
        $('.attend-btn').each(function() {
            $(this).on('click', function() {
                $(this).prop('disabled', true).html(`
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    ...
                `);
                return true;
            });
        });
    </script>
@endsection
