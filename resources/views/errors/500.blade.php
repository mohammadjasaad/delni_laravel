@extends('errors.layout')

@section('title', 'Server Error')
@section('code', '500')
@section('message', __('messages.error_500_message', [], app()->getLocale()) ?? 'Something went wrong on our server')
