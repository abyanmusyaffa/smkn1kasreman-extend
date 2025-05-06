{{-- @dd($$passing_certificate) --}}
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SKL-{{ $alumni->name }}</title>  
    <style>
        /* Base styles */
        @page {
          margin: 20px 0;
        }
        body {
          font-family: 'Times New Roman';
          margin: 0 ;
          padding: 0 ;
          width: 100%;
        }
        .single-page-container {
          width: 70%;
          margin: 0 auto;
        }

        .w-full {
          width: 100%;
        }

        .w-20 {
          width: 56px;
        }

        .w-half {
          width: 35%;
        }

        .w-8p {
          width: 8.333333%;
        }

        .w-16p {
          width: 16.666667%;
        }

        /* Lines and dividers */
        .divider {
          height: 2px;
          background-color: #000000;
          width: 100%;
          margin: 4px 0;
        }

        /* Layout and positioning */
        /* .center {
          text-align: center;
          margin: 0 auto;
        } */

        .right-align {
          text-align: right;
        }

        /* Spacing */
        .m-t-4 {
          margin-top: 4px;
        }

        .p-l-0 tr td {
          padding-left: 0;  
        }
        .m-b-4 {
          margin-bottom: 4px;
        }

        .m-t-8 {
          margin-top: 8px;
        }

        .m-b-8 {
          margin-bottom: 8px;
        }

        .m-t-56 {
          margin-top: 56px;
        }

        .m-x-16 {
          margin-left: 16px;
          margin-right: 16px;
        }

        .m-y-2 {
          margin-top: 2px;
          margin-bottom: 2px;
        }

        .m-b-8 {
          margin-bottom: 8px;
        }

        .p-l-48 {
          padding-left: 48px;
        }

        .p-r-48 {
          padding-right: 48px;
        }

        .p-r-32 {
          padding-right: 32px;
        }

        /* Text styling */
        .text-center {
          text-align: center;
        }

        .text-right {
          text-align: right;
        }

        .text-12 {
          font-size: 12pt;
        }

        .text-13 {
          font-size: 13pt;
        }

        .text-14 {
          font-size: 14pt;
        }
        .text-11 {
          font-size: 11pt;
        }

        .text-10 {
          font-size: 10pt;
        }
        .text-9 {
          font-size: 9pt;
        }
        .text-8 {
          font-size: 8pt;
        }

        .line-1 {
          line-height: 1;
        }

        .font-sans {
          font-family: Arial;
        }

        .font-bold {
          font-weight: bold;
        }

        .underline {
          text-decoration: underline;
        }
        .italic {
          font-style: italic;
        }
        .align-top {
          vertical-align: top;
        }

        /* Tables */
        table {
          border-collapse: collapse;
          width: 100%;
        }

        td {
          padding: 3px;
        }

        .bordered td {
          border: 1px solid #000000;
        }

        /* Structure elements */
        .header {
          width: 100%;
          display: block;
        }

        .logo {
          float: left;
          margin: 0;
          padding: 0;
        }

        .header-text {
          text-align: center;
        }

        .clearfix:after {
          content: "";
          display: table;
          clear: both;
        }

        .main-content {
          width: 100%;
          clear: both;
        }

        .article {
        text-align: left;
          width: 100%;
          margin-bottom: 10px;
        }

        .footer {
          text-align: left;
          /* padding-right: 32px; */
          margin-top: 10px;
        }

        h1, h2, h3, h4, h5, h6 {
          margin: 0;
          padding: 0;
        }

        p {
          margin: 0 0;
        }
        table {
          page-break-inside: avoid !important;
        }

        /* .signature-block {
          float: right;
          text-align: left;
          margin-right: 32px;
        } */
    </style>
  </head>
  <body>
    <div class="single-page-container">
        <div class="header clearfix">
            <div class="logo">
              {{-- <img src="{{ 'storage/' . $passing_certificate->logo }}" class="w-20" alt=""> --}}
              <img src="{{ $srcLogo }}" class="w-20" alt="">
            </div>
            <div class="header-text" style="font-family: Arial, sans-serif">
                {{-- <h2 class="text-12 font-bold">PEMERINTAH PROVINSI JAWA TIMUR <br> DINAS PENDIDIKAN <br> SEKOLAH MENENGAH KEJURUAN NEGERI 1 <br> KASREMAN - NGAWI</h2> --}}
                <p class="text-11">{!! str_replace('\N', '<br>', strtoupper($passing_certificate->letterhead)) !!}</p>
                <h1 class="text-12 font-bold">SMK NEGERI {{ strtoupper($passing_certificate->school) }}</h1>
                <p class="text-8">{{ $passing_certificate->address }}<br>Telepon {{ $passing_certificate->phone }}</p>
            </div>
        </div>
        <div class="divider m-b-8"></div>
        
        <div class="main-content">
            <div class="text-center m-b-8">
                <h1 class="text-12 underline line-1 font-bold">SURAT KETERANGAN LULUS</h1>
                <p class="text-10">Nomor: {{ $certificate->number ?? $passing_certificate->number }}</p>
            </div>
            <div class="article" >
                <p class="text-10">Yang bertanda tangan di bawah ini, Kepala Sekolah Menengah Kejuruan Negeri {{ $passing_certificate->school }} Kabupaten Ngawi, Provinsi Jawa Timur menerangkan bahwa :</p>
                <table class="p-l-0 m-y-2 text-10">
                    <tr>
                        <td class="w-half">Satuan Pendidikan</td>
                        <td>: SMK NEGERI {{ strtoupper($passing_certificate->school) }}</td>
                    </tr>
                    <tr>
                        <td>Nomor Pokok Sekolah Nasional</td>
                        <td>: {{ $passing_certificate->npsn }}</td>
                    </tr>
                    <tr>
                        <td>Nama Lengkap</td>
                        <td>: {{ strtoupper($alumni->name) }}</td>
                    </tr>
                    <tr>
                        <td>Tempat, dan Tanggal Lahir</td>
                        <td>: {{ ucwords(strtolower($alumni->birth_place)) }}, {{ Carbon\Carbon::parse($alumni->birth_date)->translatedFormat('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td>Nomor Induk Siswa Nasional</td>
                        <td>: {{ $alumni->nisn }}</td>
                    </tr>
                    <tr>
                        <td>Nomor Induk Siswa</td>
                        <td>: {{ $alumni->nis}}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Kelulusan</td>
                        <td>: {{ Carbon\Carbon::parse($certificate->date ?? $passing_certificate->date)->translatedFormat('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td>Program Keahlian</td>
                        <td>: {{ $alumni->groups->majors->expertise_program }}</td>
                    </tr>
                    <tr>
                        <td>Konsentrasi Keahlian</td>
                        <td>: {{ $alumni->groups->majors->expertise_concentration }}</td>
                    </tr>
                </table>
                <p class="text-10">telah dinyatakan</p>
                <h2 class="text-12 text-center font-bold">LULUS</h2>
            </div>
            <div class="article">
                <p class="text-10">dari satuan pendidikan berdasarkan kriteria kelulusan SMK Negeri {{ $passing_certificate->school }} Kabupaten Ngawi Tahun Ajaran {{ $alumni->academic_year }}, dengan nilai sebagai berikut :</p>
                <table class="bordered text-10 m-t-8">
                    <tr class="text-center font-bold">
                        <td class="w-8p">NO</td>
                        <td>Mata Pelajaran</td>
                        <td class="w-16p">Nilai</td>
                    </tr>
                    <tr>
                        <td class="font-bold" colspan="2">{{ $score_categories[0]->name }}</td>
                        <td></td>
                    </tr>
                    @foreach($scoreA as $score)
                      <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $score->subjects->name }}</td>
                        <td class="text-center">{{ number_format(round($score->score, 1), 2) }}</td>
                      </tr>
                    @endforeach
                    <tr>
                      <td class="font-bold" colspan="2">{{ $score_categories[1]->name }}</td>
                        <td></td>
                    </tr>
                    @foreach($scoreB as $score)
                      <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $score->subjects->name }}</td>
                        <td class="text-center">{{ number_format(round($score->score, 1), 2) }}</td>
                      </tr>
                    @endforeach
                    @if($scoreD->count() === 1)
                      <tr>
                        <td class="text-center">9</td>
                        <td>{{ $score_categories[3]->name  }} : {{ $scoreD->first()->subjects->name }}</td>
                        <td class="text-center">{{ number_format(round($scoreD->first()->score, 1), 2) }}</td>
                      </tr>
                    @else 
                      <tr>
                        <td class="text-center align-top" rowspan="3">9</td>
                        <td>{{ $score_categories[3]->name  }} :</td>
                        <td class="text-center"></td>
                      </tr>
                      @foreach($scoreD as $score)
                      <tr>
                        <td class="italic">{{ $score->subjects->name }}</td>
                        <td class="text-center">{{ number_format(round($score->score, 1), 2) }}</td>
                      </tr>
                      @endforeach
                    @endif
                    <tr>
                        <td class="font-bold" colspan="2">{{ $score_categories[2]->name }}</td>
                        <td></td>
                    </tr>
                    @foreach($scoreC as $score)
                    <tr>
                      <td class="text-center">{{ $loop->iteration }}</td>
                      <td>{{ $score->subjects->name }}</td>
                      <td class="text-center">{{ number_format(round($score->score, 1), 2) }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td class="font-bold text-center" colspan="2">Rata-Rata</td>
                        <td class="text-center font-bold">{{ number_format(round($alumni->scores->avg('score'), 1), 2) }}</td>
                    </tr>
                </table>
                <p class="text-10 m-t-8" >Surat Keterangan Lulus ini berlaku sementara sampai dengan diterbitkannya Ijazah Tahun Ajaran {{ $alumni->academic_year }}, untuk menjadikan maklum bagi yang berkepentingan.</p>
            </div>
        </div>
        
        <div class="footer" style="width: 100%; margin-top: 20px;">
          <table class="" style="width: 100%;  border-collapse: collapse;">
              <tr>
                  <td style="vertical-align: middle; text-align: left;">
                      <img src="{{ $srcQRCode }}" style="width: 100px;" alt="QR Code">
                  </td>
                  <td style="width: 100%; vertical-align: middle; text-align: right;">
                      <img src="{{ $srcPhoto }}" style="width: 108px;  margin-right: 60px;" alt="Photo">
                  </td>
                  <td style="width: auto; vertical-align: middle; text-align: right; position: relative; padding: 0;">
                      <p style="font-size: 10pt; margin: 0; text-align: center;">{{ $passing_certificate->regency }}, {{ Carbon\Carbon::parse($certificate->date ?? $passing_certificate->date)->translatedFormat('d F Y') }}</p>
                      <p style="font-size: 10pt; margin: 0; text-align: center; white-space: nowrap">Kepala SMK Negeri {{ $passing_certificate->school }}</p>
                      <div style="height: 50px; position: relative;">
                          <img src="{{ $srcSign }}" style="width: 150px; position: absolute; right: 20px;" alt="Signature">
                          <img src="{{ $srcStamp }}" style="width: 150px; position: absolute; right: 120px; bottom: -40px;" alt="Stamp">
                      </div>
                      <p style="font-size: 10pt; margin: 0; text-align: center; text-decoration: underline; font-weight: bold;">{{ $passing_certificate->headmaster }}</p>
                      <p style="font-size: 10pt; margin: 0; text-align: center;">NIP. {{ $passing_certificate->nip }}</p>
                  </td>
              </tr>
          </table>
      </div>
        {{-- <div class="footer">
          <table class="" style="width: auto">
            <tr>
              <td>
                <img src="{{ $srcQRCode }}" style="width: 80px" alt="">
              </td>
              <td style="width: 100%; text-align: right; padding-right: 60px">
                <img src="{{ $srcPhoto }}" style="width: 80px" alt="">
              </td>
              <td style="white-space: nowrap;  position: relative" class="text-10">
                <p class=" text-center">{{ $passing_certificate->regency }}, {{ Carbon\Carbon::parse($certificate->date)->translatedFormat('d F Y') }}</p>
                <p class=" text-center">Kepala SMK Negeri {{ $passing_certificate->school }}</p>
                <img src="{{ $srcSign }}" style="width: 150px" alt="">
                <img src="{{ $srcStamp }}" style="width: 150px; position: absolute; right: 120px; bottom: 0;" alt="">
                <p class="underline line-1 font-bold text-center">{{ $passing_certificate->headmaster }}</p>
                <p class="text-center">NIP. {{ $passing_certificate->nip }}</p>
              </td>
            </tr>
          </table>
        </div> --}}
    </div>
  </body>
</html>