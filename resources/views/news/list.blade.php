@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('News Articles') }}</h1>

    <!-- Main Content goes here -->
    @role('wartawan')
    <a href="{{ route('news.create') }}" class="btn btn-primary mb-3">New Article</a>
    @endrole
    
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Views</th>
                            <th>Published</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($news as $article)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('news.show', $article->id) }}">{{ $article->title }}</a>
                                </td>
                                <td>{{ $article->category->name ?? 'N/A' }}</td>
                                <td>{{ $article->user->name ?? 'N/A' }}</td>
                                <td>
                                    @if ($article->status == 'published')
                                        <span class="badge badge-success">Published</span>
                                    @elseif ($article->status == 'draft')
                                        <span class="badge badge-warning">Draft</span>
                                    @else
                                        <span class="badge badge-secondary">{{ ucfirst($article->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $article->views }}</td>
                                <td>
                                    @if ($article->published_at)
                                        {{ $article->published_at }}
                                    @else
                                        <span class="text-muted">Not published</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        @if ($article->status == 'draft' && auth()->user()->hasRole('editor'))
                                            <form action="{{ route('news.publish', ['news' => $article->id]) }}"
                                                method="post" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success mr-1" title="Publish">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('news.edit', ['news' => $article->id]) }}"
                                            class="btn btn-sm btn-primary mr-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        @role(['admin', 'editor'])
                                        <form action="{{ route('news.destroy', ['news' => $article->id]) }}"
                                            method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this article?')"
                                                title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form> 
                                        @endrole
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No news articles found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $news->links() }}
        </div>
    </div>

    <!-- End of Main Content -->
@endsection

@push('css')
    <style>
        .badge {
            font-size: 85%;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            // If you want to use DataTables, uncomment this
            // $('#dataTable').DataTable();
        });
    </script>
@endpush

@push('notif')
    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('warning'))
        <div class="alert alert-warning border-left-warning alert-dismissible fade show" role="alert">
            {{ session('warning') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success border-left-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
@endpush
