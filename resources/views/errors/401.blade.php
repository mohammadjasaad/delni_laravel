@extends('errors.layout')

@section('title', 'Unauthorized')
@section('code', '401')
@section('message', __('messages.error_401_message', [], app()->getLocale()) ?? 'Unauthorized access')
