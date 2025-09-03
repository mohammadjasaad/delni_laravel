@extends('errors.layout')

@section('title', 'Page Expired')
@section('code', '419')
@section('message', __('messages.error_419_message', [], app()->getLocale()) ?? 'Session expired, please refresh')
