<?php
namespace App\Filament\Resources\Blogs\Schemas;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class BlogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // BASIC INFO
                Section::make('Blog Info')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, $set) =>
                                $set('slug', \Str::slug($state))
                            ),
                        TextInput::make('slug')
                            ->required(),
                        Textarea::make('excerpt')
                            ->rows(3)
                            ->columnSpanFull(),
                        // RICH CONTENT WITH IMAGE SUPPORT
                        RichEditor::make('content')
                            ->required()
                            // ->disk('public')
                            ->fileAttachmentsDirectory('blog-content')
                            ->fileAttachmentsDisk('public')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'bulletList',
                                'orderedList',
                                'h1',
                                'h2',
                                'h3',
//                                 'h4',
//                                 'h5',
//                                 'h6',
                                'blockquote',
                                'codeBlock',
                                'attachFiles', //  image upload
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                // MEDIA
                Section::make('Media')
                    ->schema([
                        FileUpload::make('featured_image')
                            ->disk('public')
                            ->image()
                            ->directory('blogs')
                            ->imagePreviewHeight('150'),
                    ]),
                //  META & STATUS
                Section::make('Publish Settings')
                    ->schema([
                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                            ])
                            ->default('draft')
                            ->required(),
                        DateTimePicker::make('published_at'),
                        Select::make('author_id')
                            ->relationship('author', 'name')
                            ->default(auth()->id())
                            ->searchable(),

                    ])
                    ->columns(3),
                // SEO SECTION
                Section::make('SEO')
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta Title'),
                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->rows(2),
                    ])
                    ->columns(2),
            ]);
    }
}
