<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OltSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('olt')->insert([

            // Banjarbaru - Huawei Big
            [
                'hostname_olt' => 'OLT01-BANJARBARU-HWI',
                'ip_address' => '172.11.11.11',
                'alamat' => 'BANJARBARU',
                'lokasi' => 'GEDUNG TELKOM',
                'longitude' => 100.00000000,
                'latitude' => -6.11111111,
                'foto_olt' => null,
                'foto_rak' => null,
                'foto_topologi' => null,
                'jenis_pembayaran' => 'PRABAYAR',
                'id_pln' => '112223000000',
                'pic_pln' => 'Telkom',
                'source' => 'DUAL',
                'vlan' => 999,
                'core_idle' => 2,
            ],
            [
                'hostname_olt' => 'OLT02-BANJARBARU-HWI',
                'ip_address' => '172.11.11.12',
                'alamat' => 'BANJARBARU',
                'lokasi' => 'GEDUNG TELKOM',
                'longitude' => 100.00000000,
                'latitude' => -6.11111111,
                'foto_olt' => null,
                'foto_rak' => null,
                'foto_topologi' => null,
                'jenis_pembayaran' => 'PASCABAYAR',
                'id_pln' => '112223000000',
                'pic_pln' => 'Telkom',
                'source' => 'DUAL',
                'vlan' => 99,
                'core_idle' => 0,
            ],

            // Banjarbaru - Nokia-Alu Big
            [
                'hostname_olt' => 'OLT03-BANJARBARU-ALU',
                'ip_address' => '172.11.11.13',
                'alamat' => 'BANJARBARU',
                'lokasi' => 'GEDUNG TELKOM',
                'longitude' => 100.00000000,
                'latitude' => -6.11111111,
                'foto_olt' => null,
                'foto_rak' => null,
                'foto_topologi' => null,
                'jenis_pembayaran' => 'PASCABAYAR',
                'id_pln' => '112223000000',
                'pic_pln' => 'Telkom',
                'source' => 'DUAL',
                'vlan' => 999,
                'core_idle' => 0,
            ],

            // Banjarmasin - ZTE Big
            [
                'hostname_olt' => 'OLT01-BANJARMASIN-ZTE',
                'ip_address' => '172.11.11.14',
                'alamat' => 'BJM CENTRUM',
                'lokasi' => 'GEDUNG TELKOM',
                'longitude' => 100.00000000,
                'latitude' => -6.11111111,
                'foto_olt' => null,
                'foto_rak' => null,
                'foto_topologi' => null,
                'jenis_pembayaran' => 'PASCABAYAR',
                'id_pln' => '112223000000',
                'pic_pln' => 'Telkom',
                'source' => 'DUAL',
                'vlan' => 99,
                'core_idle' => 0,
            ],

            // Batulicin - Huawei Big
            [
                'hostname_olt' => 'OLT01-BATULICIN-HWI',
                'ip_address' => '172.11.11.15',
                'alamat' => 'BATULICIN',
                'lokasi' => 'GEDUNG TELKOM',
                'longitude' => 100.00000000,
                'latitude' => -6.11111111,
                'foto_olt' => null,
                'foto_rak' => null,
                'foto_topologi' => null,
                'jenis_pembayaran' => 'PASCABAYAR',
                'id_pln' => '112223000000',
                'pic_pln' => 'Telkom',
                'source' => 'DUAL',
                'vlan' => 999,
                'core_idle' => 0,
            ],

            // Pelaihari - ZTE Big
            [
                'hostname_olt' => 'OLT01-PELEIHARI-ZTE',
                'ip_address' => '172.11.11.16',
                'alamat' => 'PELEIHARI',
                'lokasi' => 'GEDUNG TELKOM',
                'longitude' => 100.00000000,
                'latitude' => -6.11111111,
                'foto_olt' => null,
                'foto_rak' => null,
                'foto_topologi' => null,
                'jenis_pembayaran' => 'PASCABAYAR',
                'id_pln' => '112223000000',
                'pic_pln' => 'Telkom',
                'source' => 'DUAL',
                'vlan' => 99,
                'core_idle' => 1,
            ],

            // Rantau - Huawei Mini
            [
                'hostname_olt' => 'OLT01-RANTAU-SUNGKAI-HWI',
                'ip_address' => '172.11.11.17',
                'alamat' => 'SUNGKAI',
                'lokasi' => 'INDOOR TOWER BTS 001',
                'longitude' => 100.00000000,
                'latitude' => -6.11111111,
                'foto_olt' => null,
                'foto_rak' => null,
                'foto_topologi' => null,
                'jenis_pembayaran' => 'PASCABAYAR',
                'id_pln' => '112223000000',
                'pic_pln' => 'Telkomsel',
                'source' => 'BELUM DUAL',
                'vlan' => 99,
                'core_idle' => 2,
            ],

            // Tanjung - Huawei Mini VRLA
            [
                'hostname_olt' => 'OLT01-TANJUNGTABALONG-HARUAI-HWI',
                'ip_address' => '172.11.11.18',
                'alamat' => 'HARUAI',
                'lokasi' => 'INDOOR TOWER BTS 002',
                'longitude' => 100.00000000,
                'latitude' => -6.11111111,
                'foto_olt' => null,
                'foto_rak' => null,
                'foto_topologi' => null,
                'jenis_pembayaran' => 'PASCABAYAR',
                'id_pln' => '112223000000',
                'pic_pln' => 'Telkomsel',
                'source' => 'BELUM DUAL',
                'vlan' => 99,
                'core_idle' => 0,
            ],
            
            // Tanjung - Huawei Mini VRLA (Lokasi Maburai)
            [
                'hostname_olt' => 'OLT01-TANJUNGTABALONG-MABURAI-HWI',
                'ip_address' => '172.11.11.19',
                'alamat' => 'MABURAI',
                'lokasi' => 'INDOOR TOWER BTS 002',
                'longitude' => 100.00000000,
                'latitude' => -6.11111111,
                'foto_olt' => null,
                'foto_rak' => null,
                'foto_topologi' => null,
                'jenis_pembayaran' => 'PASCABAYAR',
                'id_pln' => '112223000000',
                'pic_pln' => 'Telkomsel',
                'source' => 'BELUM DUAL',
                'vlan' => 999,
                'core_idle' => 4,
            ],

            // Pulau Laut - Fiberhome Mini VRLA
            [
                'hostname_olt' => 'OLT01-PULAULAUT-TANJUNGTENGAH-FIBERHOME',
                'ip_address' => '172.11.11.20',
                'alamat' => 'TANJUNG TENGAH',
                'lokasi' => 'OUTDOOR TOWER BTS 003',
                'longitude' => 100.00000000,
                'latitude' => -6.11111111,
                'foto_olt' => null,
                'foto_rak' => null,
                'foto_topologi' => null,
                'jenis_pembayaran' => 'PASCABAYAR',
                'id_pln' => '112223000000',
                'pic_pln' => 'Telkomsel',
                'source' => 'BELUM DUAL',
                'vlan' => 99,
                'core_idle' => 2,
            ],
        ]);
    }
}
