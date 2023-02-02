@extends('errors::illustrated-layout')

@section('title', __('auth.500'))
@section('code', '500')
@section('message', __($exception->getMessage() ?: __('auth.500')))