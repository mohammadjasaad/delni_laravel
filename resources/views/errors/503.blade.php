@extends('errors.layout')

@section('title', 'Service Unavailable')
@section('code', '503')
@section('message', __('messages.error_503_message', [], app()->getLocale()) ?? 'Service temporarily unavailable')
