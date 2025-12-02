@extends('Layout.master')

@section('title', 'Profile')

@section('admincontent')
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <!-- Profile Card -->
            <div class="card shadow-3d border-0 rounded-3 overflow-hidden">
                <!-- Header Section with Gradient -->
                <div class="profile-header" style="background: linear-gradient(45deg, #4f46e5, #7c3aed); padding: 3rem 2rem 2rem;">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="profile-avatar-wrapper">
                                @if(Auth::user()->photo)
                                    <img src="{{ asset('storage/profiles/' . Auth::user()->photo) }}"
                                         alt="Profile Photo"
                                         class="profile-avatar shadow-lg">
                                @else
                                    <div class="profile-avatar-placeholder shadow-lg">
                                        <i class="fas fa-user fa-2x text-white"></i>
                                    </div>
                                @endif
                                <div class="online-indicator"></div>
                            </div>
                        </div>
                        <div class="col">
                            <h1 class="text-white mb-1">{{ Auth::user()->name }}</h1>
                            <p class="text-light mb-0 opacity-75">
                                <i class="fas fa-envelope me-2"></i>{{ Auth::user()->email }}
                            </p>
                            <div class="mt-2">
                                <span class="badge bg-light text-primary px-3 py-2 rounded-pill">
                                    <i class="fas fa-star me-1"></i>Active Member
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Details Section -->
                <div class="card-body p-4">
                    <div class="row g-4">
                        <!-- Account Information -->
                        <div class="col-md-6">
                            <div class="info-card h-100">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper bg-primary">
                                        <i class="fas fa-user-circle text-white"></i>
                                    </div>
                                    <h5 class="mb-0 ms-3 text-dark">Account Information</h5>
                                </div>
                                <div class="info-list">
                                    <div class="info-item d-flex align-items-center py-2">
                                        <i class="fas fa-user text-primary me-3"></i>
                                        <div>
                                            <small class="text-muted">Full Name</small>
                                            <p class="mb-0 fw-semibold">{{ Auth::user()->name }}</p>
                                        </div>
                                    </div>
                                    <div class="info-item d-flex align-items-center py-2">
                                        <i class="fas fa-envelope text-primary me-3"></i>
                                        <div>
                                            <small class="text-muted">Email Address</small>
                                            <p class="mb-0 fw-semibold">{{ Auth::user()->email }}</p>
                                        </div>
                                    </div>
                                    <div class="info-item d-flex align-items-center py-2">
                                        <i class="fas fa-calendar-plus text-primary me-3"></i>
                                        <div>
                                            <small class="text-muted">Member Since</small>
                                            <p class="mb-0 fw-semibold">
                                                {{ Auth::user()->created_at->format('F d, Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Account Status -->
                        <div class="col-md-6">
                            <div class="info-card h-100">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper bg-success">
                                        <i class="fas fa-chart-line text-white"></i>
                                    </div>
                                    <h5 class="mb-0 ms-3 text-dark">Account Status</h5>
                                </div>
                                <div class="status-grid">
                                    <div class="status-item text-center p-3 rounded-3">
                                        <div class="status-icon bg-info bg-opacity-10 rounded-circle mx-auto mb-2">
                                            <i class="fas fa-check-circle text-info"></i>
                                        </div>
                                        <h6 class="mb-1">Verified</h6>
                                        <small class="text-muted">Email Verified</small>
                                    </div>
                                    <div class="status-item text-center p-3 rounded-3">
                                        <div class="status-icon bg-warning bg-opacity-10 rounded-circle mx-auto mb-2">
                                            <i class="fas fa-clock text-warning"></i>
                                        </div>
                                        <h6 class="mb-1">Active</h6>
                                        <small class="text-muted">Account Active</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex gap-3 justify-content-center flex-wrap">
                                <form action="{{ route('student.edit', ['student' => auth()->user()]) }}" method="GET">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-lg px-4 py-2 rounded-2 shadow-sm">
                                        <i class="fas fa-edit me-2"></i>Edit Profile
                                    </button>
                                </form>

                                <button class="btn btn-outline-primary btn-lg px-4 py-2 rounded-2 shadow-sm">
                                    <i class="fas fa-share-alt me-2"></i>Share Profile
                                </button>

                                <button class="btn btn-light btn-lg px-4 py-2 rounded-2 shadow-sm">
                                    <i class="fas fa-download me-2"></i>Export Data
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Stats -->
                <div class="card-footer bg-light border-0 py-3">
                    <div class="row text-center">
                        <div class="col-md-3 col-6">
                            <div class="stat-item">
                                <h4 class="text-primary mb-1">0</h4>
                                <small class="text-muted">Courses</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="stat-item">
                                <h4 class="text-success mb-1">0</h4>
                                <small class="text-muted">Completed</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="stat-item">
                                <h4 class="text-warning mb-1">0</h4>
                                <small class="text-muted">In Progress</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="stat-item">
                                <h4 class="text-info mb-1">0</h4>
                                <small class="text-muted">Certificates</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-header {
    position: relative;
    overflow: hidden;
}

.profile-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.1);
    transform: rotate(30deg);
}

.profile-avatar-wrapper {
    position: relative;
}

.profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 4px solid rgba(255, 255, 255, 0.3);
    object-fit: cover;
}

.profile-avatar-placeholder {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 4px solid rgba(255, 255, 255, 0.3);
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
}

.online-indicator {
    position: absolute;
    bottom: 10px;
    right: 10px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #10b981;
    border: 3px solid white;
}

.shadow-3d {
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1), 0 4px 6px rgba(0, 0, 0, 0.05);
}

.info-card {
    background: #fff;
    border-radius: 1rem;
    padding: 1.5rem;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.icon-wrapper {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.status-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.status-item {
    background: rgba(0, 0, 0, 0.02);
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.status-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.info-list .info-item {
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.info-list .info-item:last-child {
    border-bottom: none;
}

.stat-item {
    padding: 0.5rem;
}

.btn {
    transition: all 0.3s ease;
    border: none;
    font-weight: 600;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.rounded-2 {
    border-radius: 0.75rem !important;
}

.rounded-3 {
    border-radius: 1rem !important;
}

@media (max-width: 768px) {
    .container-fluid {
        padding: 1rem !important;
    }

    .profile-header {
        padding: 2rem 1rem 1rem !important;
        text-align: center;
    }

    .profile-avatar, .profile-avatar-placeholder {
        width: 100px;
        height: 100px;
    }

    .status-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<!-- Font Awesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

@endsection
