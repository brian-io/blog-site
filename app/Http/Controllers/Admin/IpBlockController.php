<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IpBlock;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class IpBlockController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(['auth', 'can:manage-security']),
        ];
    }

    public function index()
    {
        $ipBlocks = IpBlock::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.ip-blocks.index', compact('ipBlocks'));
    }

    public function create()
    {
        return view('admin.ip-blocks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ip_address' => 'required|ip|unique:ip_blocks,ip_address',
            'type' => 'required|in:' . IpBlock::TYPE_BLACKLIST . ',' . IpBlock::TYPE_WHITELIST,
            'reason' => 'required|string|max:255',
            'expires_at' => 'nullable|date|after:now',
            'is_active' => 'boolean'
        ]);

        IpBlock::create($validated);

        return redirect()->route('admin.ip-blocks.index')
            ->with('success', 'IP block rule created successfully!');
    }

    public function edit(IpBlock $ipBlock)
    {
        return view('admin.ip-blocks.edit', compact('ipBlock'));
    }

    public function update(Request $request, IpBlock $ipBlock)
    {
        $validated = $request->validate([
            'ip_address' => 'required|ip|unique:ip_blocks,ip_address,' . $ipBlock->id,
            'type' => 'required|in:' . IpBlock::TYPE_BLACKLIST . ',' . IpBlock::TYPE_WHITELIST,
            'reason' => 'required|string|max:255',
            'expires_at' => 'nullable|date|after:now',
            'is_active' => 'boolean'
        ]);

        $ipBlock->update($validated);

        return redirect()->route('admin.ip-blocks.index')
            ->with('success', 'IP block rule updated successfully!');
    }

    public function destroy(IpBlock $ipBlock)
    {
        $ipBlock->delete();

        return redirect()->route('admin.ip-blocks.index')
            ->with('success', 'IP block rule deleted successfully!');
    }
}
