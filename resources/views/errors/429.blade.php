@extends('errors.layout')

@section('title', 'Too Many Requests')
@section('code', '429')
@section('message', __('messages.error_429_message', [], app()->getLocale()) ?? 'Too many requests, please try again later')
