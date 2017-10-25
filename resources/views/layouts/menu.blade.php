<li class="{{ Request::is('pemasoks*') ? 'active' : '' }}">
    <a href="{!! route('result') !!}"><i class="fa fa-bar-chart"></i><span>Hasil</span></a>
</li>

<li class="{{ Request::is('kriterias*') ? 'active' : '' }}">
    <a href="{!! route('kriterias.index') !!}"><i class="fa fa-check-square-o"></i><span>Kriteria</span></a>
</li>

<li class="{{ Request::is('experts*') ? 'active' : '' }}">
    <a href="{!! route('experts.index') !!}"><i class="fa fa-user"></i><span>Expert</span></a>
</li>
<li class="{{ Request::is('pemasoks*') ? 'active' : '' }}">
    <a href="{!! route('pemasoks.index') !!}"><i class="fa fa-child"></i><span>Pemasok</span></a>
</li>
