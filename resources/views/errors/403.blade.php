@extends('errors.layout')

@section('title', 'Forbidden')
@section('code', '403')
@section('message', __('messages.error_403_message', [], app()->getLocale()) ?? 'Access denied')
