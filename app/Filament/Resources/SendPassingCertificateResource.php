<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Score;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ScoreCategory;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Resources\Resource;
use App\Models\PassingCertificate;
use Filament\Tables\Actions\Action;
use Filament\Tables\Grouping\Group;
use Illuminate\Support\Facades\Http;
use App\Models\SendPassingCertificate;
use Filament\Forms\Components\Section;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SendPassingCertificateResource\Pages;
use App\Filament\Resources\SendPassingCertificateResource\RelationManagers;

class SendPassingCertificateResource extends Resource
{
    protected static ?string $model = SendPassingCertificate::class;

    protected static ?string $modelLabel = 'Surat Keterangan Lulus';
    protected static ?string $pluralModelLabel = 'Surat Keterangan Lulus';

    protected static ?string $navigationGroup = 'SKL';
    protected static ?string $navigationIcon = 'fas-file-contract';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                ->columns([
                    'default' => 2,
                    'lg' => 12,
                ])
                ->schema([
                    Forms\Components\Select::make('alumni_id')
                        ->label('Nama')
                        ->native(false)
                        ->relationship(name: 'alumnis', titleAttribute: 'name')
                        ->label('Alumni')
                        ->required()
                        ->searchable()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\TextInput::make('number')
                        ->label('Nomor SKL')
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 9,
                        ]),
                    Forms\Components\DatePicker::make('date')
                        ->label('Tanggal SKL')
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 3,
                        ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('alumnis.groups.name')
                    ->label('Kelas'),
                Group::make('alumnis.groups.majors.alias')
                    ->label('Jurusan'),
            ])
            ->defaultGroup('alumnis.groups.name')
            ->columns([
                Tables\Columns\TextColumn::make('alumnis.nis')
                    ->label('NIS')
                    ->searchable()
                    ->url(fn ($record) => route('filament.admin.resources.alumnis.edit', ['record' => $record->alumnis->id]))
                    ->openUrlInNewTab(false),
                Tables\Columns\TextColumn::make('alumnis.name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => route('filament.admin.resources.alumnis.edit', ['record' => $record->alumnis->id]))
                    ->openUrlInNewTab(false),
                Tables\Columns\TextColumn::make('alumnis.groups.majors.alias')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'TKJ' => 'danger',
                        'AKL' => 'warning',
                        'KL' => 'success',
                        'DPB' => 'info',
                    })
                    ->label('Jurusan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('number')
                    ->label('Nomor SKL')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Tanggal Lulus')
                    ->formatStateUsing(fn ($state) => Carbon::parse($state)->translatedFormat('d F Y'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('download_passing_certificate')
                    ->label('Download')
                    ->icon('fas-arrow-down')
                    ->action(function ($record) {
                        $alumni = $record->alumnis;
                
                        if (!$alumni) {
                            Notification::make()
                                ->title('Data Alumni belum tersedia')
                                ->danger()
                                ->send();
                            return null;
                        }

                        $major = $alumni->groups->majors->alias ?? null;

                        $scoreCount = $alumni->scores->count();

                        $requiredScoreCount = match ($major) {
                            'AKL' => 15,
                            'TKJ', 'KL', 'DPB' => 14,
                            default => 0,
                        };

                        if ($scoreCount < $requiredScoreCount) {
                            Notification::make()
                                ->title("Nilai belum lengkap (dari $scoreCount, seharusnya $requiredScoreCount)")
                                ->danger()
                                ->send();
                            return null;
                        }
                        $score_categories = ScoreCategory::all();
                        $scores = Score::with('subjects.score_categories')
                            ->where('alumni_id', $alumni->id)
                            ->get();
                
                        // Filter berdasarkan kategori nama
                        $scoreA = $scores->filter(fn($s) => $s->subjects->score_categories->name === $score_categories[0]->name );
                        $scoreB = $scores->filter(fn($s) => $s->subjects->score_categories->name === $score_categories[1]->name );
                        $scoreC = $scores->filter(fn($s) => $s->subjects->score_categories->name === $score_categories[2]->name );
                        $scoreD = $scores->filter(fn($s) => $s->subjects->score_categories->name === $score_categories[3]->name );
                        
                        $passing_certificate = PassingCertificate::find(1);
                        
                        $imagePathLogo = storage_path('app/public/' . $passing_certificate->logo);
                        $imagePathPhoto = storage_path('app/public/' . $alumni->photo);
                        $imagePathStamp = storage_path('app/public/' . $passing_certificate->stamp);
                        $imagePathQRCode = storage_path('app/public/' . $passing_certificate->qrcode);
                        $imagePathSign = storage_path('app/public/' . $passing_certificate->signature);

                        $imageDataLogo = base64_encode(file_get_contents($imagePathLogo));
                        $imageDataPhoto = base64_encode(file_get_contents($imagePathPhoto));
                        $imageDataStamp = base64_encode(file_get_contents($imagePathStamp));
                        $imageDataQRCode = base64_encode(file_get_contents($imagePathQRCode));
                        $imageDataSign = base64_encode(file_get_contents($imagePathSign));

                        $srcLogo = 'data:image/png;base64,'.$imageDataLogo;
                        $srcPhoto = 'data:image/png;base64,'.$imageDataPhoto;
                        $srcStamp = 'data:image/png;base64,'.$imageDataStamp;
                        $srcQRCode = 'data:image/png;base64,'.$imageDataQRCode;
                        $srcSign = 'data:image/png;base64,'.$imageDataSign;
                        
                        $pdf = Pdf::loadView('pdf.passing-certificate', [
                            'passing_certificate' => $passing_certificate,
                            'alumni' => $alumni,
                            'certificate' => $record,
                            'score_categories' => $score_categories,
                            'scoreA' => $scoreA,
                            'scoreB' => $scoreB,
                            'scoreC' => $scoreC,
                            'scoreD' => $scoreD,
                            'srcLogo' => $srcLogo,
                            'srcPhoto' => $srcPhoto,
                            'srcStamp' => $srcStamp,
                            'srcQRCode' => $srcQRCode,
                            'srcSign' => $srcSign,
                        ])
                        ->setPaper([0, 0, 595.28, 935.43]);
                
                        return response()->streamDownload(
                            fn () => print($pdf->stream()),
                            'SKL-' . $alumni->name . '.pdf'
                        );
                    })
                    ->color('success')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSendPassingCertificates::route('/'),
            'create' => Pages\CreateSendPassingCertificate::route('/create'),
            'edit' => Pages\EditSendPassingCertificate::route('/{record}/edit'),
        ];
    }
}