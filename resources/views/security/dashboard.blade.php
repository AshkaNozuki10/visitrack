@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Expected Visitors Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Expected Visitors Today</h3>
            <p class="text-3xl font-bold text-primary">{{ $expectedVisitors->count() }}</p>
        </div>

        <!-- Current Visitors Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Current Visitors</h3>
            <p class="text-3xl font-bold text-primary">{{ $currentVisitors->count() }}</p>
        </div>

        <!-- Walk-in Visitors Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Walk-in Visitors Today</h3>
            <p class="text-3xl font-bold text-primary">{{ $walkInCount }}</p>
        </div>
    </div>

    <!-- Expected Visitors List -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold text-gray-700">Expected Visitors</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purpose</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expected Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($expectedVisitors as $visitor)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $visitor['name'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $visitor['purpose'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $visitor['department'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $visitor['expected_time'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $visitor['status'] === 'Checked In' ? 'bg-green-100 text-green-800' : 
                                   ($visitor['status'] === 'Checked Out' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ $visitor['status'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($visitor['status'] === 'Not Arrived')
                            <form action="{{ route('security.check-in') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $visitor['user_id'] }}">
                                <input type="hidden" name="location" value="1">
                                <button type="submit" class="text-primary hover:text-primary-dark">Check In</button>
                            </form>
                            @elseif($visitor['status'] === 'Checked In')
                            <form action="{{ route('security.check-out') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="visit_id" value="{{ $visitor['visit_id'] }}">
                                <button type="submit" class="text-primary hover:text-primary-dark">Check Out</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Current Visitors List -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold text-gray-700">Current Visitors</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check-in Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($currentVisitors as $visitor)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $visitor['name'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $visitor['check_in_time'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $visitor['location'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('security.check-out') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="visit_id" value="{{ $visitor['visit_id'] }}">
                                <button type="submit" class="text-primary hover:text-primary-dark">Check Out</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 