use LibraryLogs

db.reviews.insertMany([
  {
    rating: 5,
    comment: "Excellent book, gripping story.",
    read_date: ISODate("2024-05-12T10:00:00Z"),
    user_id: ObjectId("5"),
    book_id: ObjectId("4")
  },
  {
    rating: 3,
    comment: "Good content but a bit slow at the start.",
    read_date: ISODate("2024-06-01T14:30:00Z"),
    user_id: ObjectId("3"),
    book_id: ObjectId("1")
  },
  {
    rating: 4,
    comment: "Very good technical book.",
    read_date: ISODate("2024-06-10T09:15:00Z"),
    user_id: ObjectId("1"),
    book_id: ObjectId("2")
  }
])

db.readingSessions.insertMany([
  {
    userId: ObjectId("6"),
    bookId: ObjectId("4"),
    pagesRead: 35,
    durationMinutes: 60,
    personalNotes: "Great start, easy to read.",
    date: ISODate("2024-06-15T18:00:00Z")

  },
  {
    userId: ObjectId("3")
    bookId: ObjectId("1"),
    pagesRead: 20,
    durationMinutes: 45,
    personalNotes: "Somewhat complex in parts.",
    date: ISODate("2024-06-16T10:00:00Z")
  },
  {
    pages_read: 50,
    time_spent: 70,
    personal_notes: "Loved chapters 3 and 4.",
    date: ISODate("2024-06-17T20:00:00Z"),
    user_id: ObjectId("1"),
    book_id: ObjectId("2")
  }
])


