use LibraryLogs

db.reviews.insertMany([
  {
    userId: 5,
    bookId: 4,
    rating: 5,
    comment: "Excellent book, gripping story.",
    read_date: ISODate("2024-05-12T10:00:00Z")
  },
  {
    userId: 3,
    bookId: 1,
    rating: 3,
    comment: "Good content but a bit slow at the start.",
    read_date: ISODate("2024-06-01T14:30:00Z")
  },
  {
    user_id: 1,
    book_id: 2,
    rating: 4,
    comment: "Very good technical book.",
    read_date: ISODate("2024-06-10T09:15:00Z")
  }
])

db.readingSessions.insertMany([
  {
    userId: 6,
    bookId: 4,
    pagesRead: 35,
    durationMinutes: 60,
    personalNotes: "Great start, easy to read.",
    date: ISODate("2024-06-15T18:00:00Z")

  },
  {
    userId: 3,
    bookId: 1,
    pagesRead: 20,
    durationMinutes: 45,
    personalNotes: "Somewhat complex in parts.",
    date: ISODate("2024-06-16T10:00:00Z")
  },
  {
    userId: 1,
    bookId: 2,
    pagesRead: 50,
    durationMinutes: 70,
    personalNotes: "Loved chapters 3 and 4.",
    date: ISODate("2024-06-17T20:00:00Z")
  }
])


