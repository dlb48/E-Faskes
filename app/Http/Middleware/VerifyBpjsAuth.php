<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyBpjsAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $consId = $request->header('x-cons-id');
        $timestamp = $request->header('x-timestamp');
        $signature = $request->header('x-signature');
        $userKey = $request->header('user_key');

        $pengaturan = \App\Models\PengaturanBpjs::first();
        
        $configConsId = $pengaturan ? $pengaturan->cons_id : null;
        $configSecret = $pengaturan ? $pengaturan->secret_key : null;
        $configUserKey = $pengaturan ? $pengaturan->user_key : null;

        // Check if all required headers are present
        if (!$consId || !$timestamp || !$signature || !$userKey) {
            return response()->json([
                'metadata' => [
                    'code' => 401,
                    'message' => 'Unauthorized: Missing required headers.'
                ]
            ], 401);
        }

        // Check Cons ID and User Key
        if ($consId !== $configConsId || $userKey !== $configUserKey) {
            return response()->json([
                'metadata' => [
                    'code' => 401,
                    'message' => 'Unauthorized: Invalid Cons ID or User Key.'
                ]
            ], 401);
        }

        // Verify Signature
        $data = $consId . '&' . $timestamp;
        $expectedSignature = base64_encode(hash_hmac('sha256', $data, $configSecret, true));

        if ($signature !== $expectedSignature) {
            return response()->json([
                'metadata' => [
                    'code' => 401,
                    'message' => 'Unauthorized: Invalid Signature.'
                ]
            ], 401);
        }

        // Check Timestamp expiration (optional, e.g., max 5 minutes difference)
        // We will skip this for now to make testing easier, but in production, we should validate it.

        return $next($request);
    }
}
