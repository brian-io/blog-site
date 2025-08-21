@extends('layouts.app')

@section('title', 'Unsubscribed from Newsletter')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center">
            <div class="mx-auto h-12 w-12 text-red-500">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h2 class="mt-6 text-3xl font-bold text-gray-900">
                You've been unsubscribed
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                We're sorry to see you go!
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <div class="text-center">
                <div class="mb-6">
                    <div class="mx-auto h-16 w-16 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
                
                <h3 class="text-lg font-medium text-gray-900 mb-2">
                    Unsubscription Confirmed
                </h3>
                
                <p class="text-gray-600 mb-6">
                    <strong>{{ $subscriber->email }}</strong> has been successfully removed from our mailing list.
                </p>

                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <h4 class="font-medium text-gray-900 mb-2">What this means:</h4>
                    <ul class="text-sm text-gray-600 text-left space-y-1">
                        <li>• You won't receive any more newsletters from us</li>
                        <li>• Your email has been removed from our database</li>
                        <li>• This change is effective immediately</li>
                    </ul>
                </div>

                <div class="space-y-4">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <h4 class="font-medium text-blue-900 mb-2">Changed your mind?</h4>
                        <p class="text-sm text-blue-700 mb-3">
                            You can always resubscribe by visiting our website and signing up again.
                        </p>
                        <a href="{{ route('blogs.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Visit Our Blog
                        </a>
                    </div>

                    <div class="bg-yellow-50 rounded-lg p-4">
                        <h4 class="font-medium text-yellow-900 mb-2">Feedback</h4>
                        <p class="text-sm text-yellow-700 mb-3">
                            We'd love to know why you unsubscribed. Your feedback helps us improve.
                        </p>
                        <a href="mailto:{{ config('mail.from.address') }}?subject=Newsletter Unsubscribe Feedback" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-yellow-800 bg-yellow-200 hover:bg-yellow-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            Send Feedback
                        </a>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <p class="text-xs text-gray-500">
                        If you believe this was done in error, please contact us at 
                        <a href="mailto:{{ config('mail.from.address') }}" class="text-blue-600 hover:text-blue-500">
                            {{ config('mail.from.address') }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection