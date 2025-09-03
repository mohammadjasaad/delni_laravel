@extends('errors.layout')

@section('title', 'Page Not Found')
@section('code', '404')
@section('message', __('messages.error_404_message', [], app()->getLocale()) ?? 'Page not found')
